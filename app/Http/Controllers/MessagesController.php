<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class MessagesController extends Controller{
    private $messagesMetaData;
    private $settingId = 7;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->messagesMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();

            return $next($request);
        });
    }

    public function showMessages(){
        try{
            return view('messages.all-messages');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MessagesController | Function: showMessages | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedMessagesData(Request $request){
        try {
            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search_value'); // Search value from DataTables

            // Custom filter inputs
            $filterFromDate = $request->input('filter_from');
            $filterToDate = $request->input('filter_to');
            $filterIsReviewed = $request->input('filter_is_reviewed');

            // Base query
            $query = DB::table($this->messagesMetaData->table_name) // Replace with your actual table name
                ->select('id', 'product_id', 'sender_name', 'sender_email', 'phone_number', 'subject', 'body', 'is_checked')
                ->where('company_id', $this->authUser->company_id)
                ->orderBy('id', 'DESC')
                ->orderBy('is_checked', 'ASC');

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('product_id', 'like', "%$searchValue%")
                    ->orWhere('sender_name', 'like', "%$searchValue%")
                    ->orWhere('subject', 'like', "%$searchValue%");
                });
            }

            if ($filterIsReviewed) {
                $query->where('is_checked', $filterIsReviewed);
            }
    
            if ($filterFromDate) {
                $query->whereDate('created_at', '>=', $filterFromDate);
            }
    
            if ($filterToDate) {
                $query->whereDate('created_at', '<=', $filterToDate);
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            if($length > -1){
                $query = $query
                            ->offset($start)
                            ->limit($length);
            }

            $messages = $query
                            ->get()
                            ->map(function ($item) {
                                $item->encrypted_id = Crypt::encrypt($item->id);
                                return $item;
                            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $messages,
            ]);
        
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MessagesController | Function: getPaginatedMessagesData | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function changeMessageReviewedStatus(Request $request){
        try{
            DB::beginTransaction();
            $isReviewed = $request->get('is_reviewed');
            $selectedMessages = json_decode($request->get('selectedMessages'));

            if(($isReviewed == 1 || $isReviewed == 0) && (count($selectedMessages) > 0)){
                $updateMessage = DB::table($this->messagesMetaData->table_name)
                                    ->whereIn('id', $selectedMessages)
                                    ->update(['is_checked' => $isReviewed, 'updated_at' => now()]);

                if($updateMessage == count($selectedMessages)){
                    DB::commit();
                    $code = 200;
                    $msg = 'translation.messages_status_changed';
                }else{
                    DB::rollBack();
                    $code = 400;
                    $msg = 'translation.messages_status_not_changed';
                }

            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.error_400';
            }

            
            return response()->json(['message' => lang::get($msg)], $code);
        }catch(Exception $e){
            DB::rollBack();
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MessagesController | Function: changeMessageReviewedStatus | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
            
    }

    public function messageDetails($messageId){
        try{

            $messageId = Crypt::decrypt($messageId);
            $message = DB::table($this->messagesMetaData->table_name)
                            ->where('id', $messageId)
                            ->first();

            $productId = $message->product_id;

            if($productId){
                $product = DB::table('products')
                                ->where('id', $productId)
                                ->first();
            }else{
                $product = null;
            }
            return view('messages.read-message', compact('message', 'product'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MessagesController | Function: messageDetails | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

}
