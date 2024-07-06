<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Classes\Image;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class PartnersOrClientsController extends Controller
{
    private $imagePath;
    private $settingId;
    private $partnersOrClientsMetaData;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    private function initSettings($type){
        if($type == 'partners'){
            $this->imagePath = 'images/partners/';
            $this->settingId = 5;
        }else if($type == 'clients'){
            $this->imagePath = 'images/clients/';
            $this->settingId = 6;
        }
        $this->partnersOrClientsMetaData = DB::table('settings_meta_data')
                                                ->where('setting_id', $this->settingId)
                                                ->first();  
    }

    public function showPartnersOrClients(){
        try{
            $currentRouteName = Route::currentRouteName();
            if($currentRouteName == 'showPartners'){
                $type = 'partners';
            }else if($currentRouteName == 'showClients'){
                $type = 'clients';
            }
            return view('partners-or-clients.all-partners-or-clients', compact('type'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: PartnersOrClientsController | Function: showPartnersOrClients | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedPartnersOrClientsData(Request $request)
    {
        try {
            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables
            $type = $request->input('type');
            $this->initSettings($type);

            // Base query
            $query = DB::table($this->partnersOrClientsMetaData->table_name) // Replace with your actual table name
                ->select('id', 'title_en', 'title_ar', 'sequence', 'is_active')
                ->selectRaw("CONCAT('$assetUrl', picture) AS picture")
                ->where('setting_id', $this->settingId)
                ->where('company_id', $this->authUser->company_id);

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('title_en', 'like', "%$searchValue%")
                    ->orWhere('title_ar', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $partnersOrClients = $query
                ->offset($start)
                ->limit($length)
                ->orderBy('sequence', 'ASC')
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $partnersOrClients,
            ]);
        
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: PartnersOrClientsController | Function: getPaginatedPartnersOrClientsData | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showCreatePartnerOrClient($type){
        try{
            return view('partners-or-clients.create-new-partner-or-client', compact('type'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: PartnersOrClientsController | Function: showCreatePartnerOrClient | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedPartnerOrClient(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'sequence' => ['required', 'integer'],
            ]);
            
            $type = $request->get('type');
            $this->initSettings($type);
            $picture = $request->file('picture');
            $pictureName = Image::savePictureInStorage($picture, $this->imagePath);
            
            $partnerOrClient = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('name_en'),
                'title_ar' => $request->get('name_ar'),
                'sequence' => $request->get('sequence'),
                'picture' => $this->imagePath . $pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $insertPartnerOrClient = DB::table($this->partnersOrClientsMetaData->table_name)
                                ->insert($partnerOrClient); 

            if($insertPartnerOrClient == 1){
                DB::commit();
                $code = 200;
                if($type == 'partners'){
                    $msg = 'translation.partner_created';
                }else if($type == 'clients'){
                    $msg = 'translation.client_created';
                }
                
            }else{
                DB::rollBack();
                $code = 400;
                if($type == 'partners'){
                    $msg = 'translation.partner_not_created';
                }else if($type == 'clients'){
                    $msg = 'translation.client_not_created';
                }
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

            Log::error("Error | Controller: PartnersOrClientsController | Function: saveCreatedPartnerOrClient | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showPartnerOrClientToUpdate($partnerOrClientid, $type){
        try{
            $this->initSettings($type);
            $partnerOrClient = DB::table($this->partnersOrClientsMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', $partnerOrClientid)
                        ->first();

            return view('partners-or-clients.update-partner-or-client', compact('partnerOrClient', 'type'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: showServiceToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedPartnerOrClient(Request $request){
        try{
            DB::beginTransaction();
            
            $request->validate([
                'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'sequence' => ['required', 'integer'],
                'is_active' => ['required', 'integer'],
            ]);

            $type = $request->get('type');
            $this->initSettings($type);

            $partnerOrClientId = $request->get('id');
            $partnerOrClient = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('name_en'),
                'title_ar' => $request->get('name_ar'),
                'sequence' => $request->get('sequence'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];
                
            $newPicture = $request->file('picture');
            if($newPicture){

                $dbPicture = $request->get('db_picture');
                Image::unlinkPicture($dbPicture);
                
                $pictureName = Image::savePictureInStorage($picture, $this->imagePath);
                $partnerOrClient['picture'] = $this->imagePath.$pictureName;
            } 

            $updatePartnerOrClient = DB::table($this->partnersOrClientsMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $partnerOrClientId)
                                ->update($partnerOrClient);    

            if($updatePartnerOrClient == 1){
                DB::commit();
                $code = 200;
                if($type == 'partners'){
                    $msg = 'translation.partner_updated';
                }else if($type == 'clients'){
                    $msg = 'translation.client_updated';
                }
            }else{
                DB::rollBack();
                $code = 400;
                if($type == 'partners'){
                    $msg = 'translation.partner_not_updated';
                }else if($type == 'clients'){
                    $msg = 'translation.client_not_updated';
                }
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
}
