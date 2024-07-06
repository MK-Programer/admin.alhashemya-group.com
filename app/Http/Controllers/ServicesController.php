<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Classes\Image;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;


class ServicesController extends Controller
{

    private $imagePath = 'images/services/';
    private $settingId = 3;
    private $servicesMetaData;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->servicesMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showServices(){
        try{
            return view('services.all-services');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: showServices | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedServicesData(Request $request)
    {
        try {
            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables

            // Base query
            $query = DB::table($this->servicesMetaData->table_name) // Replace with your actual table name
                ->select('id', 'title_en', 'title_ar', 'desc_en', 'desc_ar', 'sequence', 'is_active')
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

            // Apply pagination
            $services = $query
                ->offset($start)
                ->limit($length)
                ->orderBy('sequence', 'ASC')
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $services,
            ]);
        
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: getPaginatedServicesData | Code: ".$code." | Message: ".$msg);

        }
    }


    public function showCreateService(){
        try{
            return view('services.create-new-service');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: showCreateService | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedService(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
                'sequence' => ['required', 'integer'],
            ]);

            $picture = $request->file('picture');
            $pictureName = Image::savePictureInStorage($picture, $this->imagePath);
            
            $service = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('title_en'),
                'title_ar' => $request->get('title_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'sequence' => $request->get('sequence'),
                'picture' => $this->imagePath . $pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insertService = DB::table($this->servicesMetaData->table_name)
                                ->insert($service);       
            if($insertService == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.service_created';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.service_not_created';
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

            Log::error("Error | Controller: ServicesController | Function: saveCreatedService | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showServiceToUpdate($serviceId){
        try{
            $service = DB::table($this->servicesMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', $serviceId)
                        ->first();

            return view('services.update-service', compact('service'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: showServiceToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedService(Request $request){
        try{
            DB::beginTransaction();
            
            $request->validate([
                'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
                'sequence' => ['required', 'integer'],
                'is_active' => ['required', 'integer'],
            ]);
            
            $serviceId = $request->get('service_id');
            $service = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('title_en'),
                'title_ar' => $request->get('title_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'sequence' => $request->get('sequence'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];
                
            $newPicture = $request->file('picture');
            if($newPicture){

                $dbPicture = $request->get('db_picture');
                Image::unlinkPicture($dbPicture);
                
                $pictureName = Image::savePictureInStorage($newPicture, $this->imagePath);
                $service['picture'] = $this->imagePath.$pictureName;
            } 

            $updateService = DB::table($this->servicesMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $serviceId)
                                ->update($service);    

            if($updateService == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.service_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.service_not_updated';
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
