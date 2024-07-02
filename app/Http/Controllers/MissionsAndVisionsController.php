<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class MissionsAndVisionsController extends Controller
{
    private $imagePath = 'images/missions-and-visions/';
    private $settingId = 3;
    private $missionsAndVisionsMetaData;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->missionsAndVisionsMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showMissionsAndVisions(){
        try{
            return view('missions-and-visions.all-missions-and-visions');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MissionsAndVisionsController | Function: showMissionsAndVisions | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedMissionsAndVisionsData(Request $request){
        try {
            // Number of records to fetch per request
            $perPage = 10;
    
            // Get the current page from the request, default is 1
            $currentPage = $request->input('page', 1);
    
            // Calculate the offset
            $offset = ($currentPage - 1) * $perPage;
    
            // Fetch the data with the calculated offset and limit using Query Builder
            $missionsAndVisions = DB::table($this->missionsAndVisionsMetaData->table_name.' as m')
                ->join($this->missionsAndVisionsMetaData->table_name.' as v', 'm.id', '=', 'v.link_with_id')
                ->select(
                    DB::raw('CONCAT(m.id, " - ", v.id) as id'),
                    'm.title_en as mission_title_en',
                    'm.title_ar as mission_title_ar',
                    'v.title_en as vision_title_en',
                    'v.title_ar as vision_title_ar',
                    'm.sequence as sequence', // sequence of mission = vision 
                    'm.is_active as is_active' // if mission is active then vision is also active
                )
                ->where('m.setting_id', $this->settingId)
                ->where('m.company_id', $this->authUser->company_id)
                ->offset($offset)
                ->limit($perPage)
                ->orderBy('m.sequence', 'ASC')
                ->get();
    
            // Count total records
            $totalRecords = DB::table($this->missionsAndVisionsMetaData->table_name)
                            ->where('setting_id', $this->settingId)
                            ->where('company_id', $this->authUser->company_id)
                            ->count() / 2;
    
            // Calculate total pages
            $totalPages = ceil($totalRecords / $perPage / 2); // Adjust the total count if necessary
    
            return response()->json([
                'data' => $missionsAndVisions,
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'per_page' => $perPage,
            ]);
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
    
            Log::error("Error | Controller: MissionsAndVisionsController | Function: getPaginatedMissionsAndVisionsData | Code: ".$code." | Message: ".$msg);
    
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showRUMissionAndVision($missionVisionId, $action){
        try{
            
            $missionVisionIds = explode(' - ', $missionVisionId);
            $missionId = $missionVisionIds[0];
            $visionId = $missionVisionIds[1];
            
            $mission = DB::table($this->missionsAndVisionsMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', $missionId)
                        ->first();

            $vision = DB::table($this->missionsAndVisionsMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', $visionId)
                        ->first();
                        
            $view = 'missions-and-visions.';
            if($action == 'update'){
                $view .= 'update';
            }else{
                $view .= 'read';
            }
            $view .= '-mission-and-vision';
            return view($view, compact('mission', 'vision'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MissionsAndVisionsController | Function: showRUMissionAndVision | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function showCreateMissionAndVision(){
        try{
            return view('missions-and-visions.create-new-mission-and-vision');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MissionsAndVisionsController | Function: showCreateMissionAndVision | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    private function savePictureInStorage($picture){
        $uuid = Str::uuid();
        $pictureName = $uuid . '.' . $picture->getClientOriginalExtension();
        $picturePath = public_path($this->imagePath);
        $picture->move($picturePath, $pictureName);
        return $pictureName;
    }

    public function saveCreatedMissionAndVision(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'mission_picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'mission_title_en' => ['required', 'string', 'max:255'],
                'mission_title_ar' => ['required', 'string', 'max:255'],
                'mission_description_en' => ['required', 'string', 'max:1000'],
                'mission_description_ar' => ['required', 'string', 'max:1000'],
                
                'vision_picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'vision_title_en' => ['required', 'string', 'max:255'],
                'vision_title_ar' => ['required', 'string', 'max:255'],
                'vision_description_en' => ['required', 'string', 'max:1000'],
                'vision_description_ar' => ['required', 'string', 'max:1000'],

                'sequence' => ['required', 'integer'],
            ]);

            // mission
            $missionPicture = $request->file('mission_picture');
            $missionPictureName = $this->savePictureInStorage($missionPicture);

            $mission = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('mission_title_en'),
                'title_ar' => $request->get('mission_title_ar'),
                'desc_en' => $request->get('mission_description_en'),
                'desc_ar' => $request->get('mission_description_ar'),
                'sequence' => $request->get('sequence'),
                'picture' => $this->imagePath.$missionPictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $missionId = DB::table($this->missionsAndVisionsMetaData->table_name)
                            ->insertGetId($mission);       

            // vision
            $visionPicture = $request->file('vision_picture');
            $visionPictureName = $this->savePictureInStorage($visionPicture);

            $vision = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('vision_title_en'),
                'title_ar' => $request->get('vision_title_ar'),
                'desc_en' => $request->get('vision_description_en'),
                'desc_ar' => $request->get('vision_description_ar'),
                'sequence' => $request->get('sequence'),
                'picture' => $this->imagePath.$visionPictureName,
                'link_with_id' => $missionId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $insertVision = DB::table($this->missionsAndVisionsMetaData->table_name)
                                ->insert($vision);       
            if($missionId != null && $insertVision == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.mission_and_vision_created';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.mission_and_vision_not_created';
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

            Log::error("Error | Controller: MissionsAndVisionsController | Function: saveCreatedMissionAndVision | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => $msg], $code);
        }
    }
    
}
