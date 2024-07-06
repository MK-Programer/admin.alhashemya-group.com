<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Classes\Image;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;


class AdminController extends Controller
{

    private $imagePath = 'images/home/';

    private $settingId = 1;
    private $HomeMetaData;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->HomeMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showHome(){
        try{
            return view('home.all-home');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AdminController | Function: showHome | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function showCreateHome(){
        try{
            return view('home.create-new-home');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: HomeController | Function: showCreateHome | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedHome(Request $request)
    {
        try{
            DB::beginTransaction();

            $request->validate([
                'picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
            ]);

            $picture = $request->file('picture');
            $pictureName = Image::savePictureInStorage($picture, $this->imagePath);

            $home = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('title_en'),
                'title_ar' => $request->get('title_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'picture' => $this->imagePath.$pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // dd(4);
            $homeHome = DB::table($this->HomeMetaData->table_name)
                                ->insert($home);

            if($homeHome == 1){
                DB::commit();
                $code = 200;
                $msg = lang::get('translation.home_created');
            }else{
                DB::rollBack();
                $code = 400;
                $msg = lang::get('translation.home_not_created');
            }
            return response()->json(['message' => $msg], $code);
        }catch(ValidationException $e){
            DB::rollBack();

            // Handle validation errors
            $errors = $e->validator->errors()->messages();

            return response()->json([
                'errors' => $errors
            ], 422);
        }catch(Exception $e){

            DB::rollBack();
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AdminController | Function: saveUpdateHome | Code: ".$code." | Message: ".$msg);
        }
    }

    public function getPaginatedHomeData(Request $request){
        try{
            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables


            //Base query
            $query =  DB::table($this->HomeMetaData->table_name) // Replace with your actual table name
                        ->select('id', 'title_en', 'title_ar', 'desc_en', 'desc_ar', 'is_active')
                        ->selectRaw("CONCAT('$assetUrl', picture) AS picture")
                        ->where('setting_id', $this->settingId)
                        ->where('company_id', $this->authUser->company_id);

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('title_en', 'like', "%$searchValue%")
                    ->orWhere('title_ar', 'like', "%$searchValue%")
                    ->orWhere('desc_en', 'like', "%$searchValue%")
                    ->orWhere('desc_ar', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();
            // Fetch the data with the calculated offset and limit using Query Builder
            $home = $query
                        ->offset($start)
                        ->limit($length)
                        ->get();
            
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $home,
            ]);

        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AdminController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);
        }
    }

    public function showHomeToUpdate($homeId){
        try{
            $home = DB::table($this->HomeMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', $homeId)
                        ->first();

            return view('home.update-home', compact('home'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AdminController | Function: showHomeToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedHome(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
                'is_active' => ['required', 'integer'],
            ]);

            $homeId = $request->get('home_id');
            $home = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('title_en'),
                'title_ar' => $request->get('title_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];

            $newPicture = $request->file('picture');
            if($newPicture){

                $dbPicture = $request->get('db_picture');
                Image::unlinkPicture($dbPicture);
                
                $pictureName = Image::savePictureInStorage($newPicture, $this->imagePath);
                $home['picture'] = $this->imagePath.$pictureName;
            }

            $updatehome = DB::table($this->HomeMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $homeId)
                                ->update($home);

            if($updatehome == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.home_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.home_not_updated';
            }
            return response()->json(['message' => lang::get($msg)], $code);
        }catch(ValidationException $e){
            DB::rollBack();

            // Handle validation errors
            $errors = $e->validator->errors()->messages();

            return response()->json([
                'errors' => $errors
            ], 422);
        }catch(Exception $e){
            DB::rollBack();
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: saveUpdatedService | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showOrders()
    {
        $orders = Message::OrderBy('created_at', 'DESC')->get();

        return view('admin.orders', compact('orders'));
    }



}
