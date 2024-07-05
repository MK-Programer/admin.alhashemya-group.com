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

class MissionsAndVisionsController extends Controller
{
    private $imagePath = 'images/missions-and-visions/';
    private $settingId = 4;
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

    public function getPaginatedMissionsAndVisionsData(Request $request)
    {
        try {
            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables

            // Base query
            $query = DB::table($this->missionsAndVisionsMetaData->table_name . ' as m')
                ->join($this->missionsAndVisionsMetaData->table_name . ' as v', 'm.id', '=', 'v.link_with_id')
                ->select(
                    DB::raw('CONCAT(m.id, " - ", v.id) as id'),
                    'm.title_en as mission_title_en',
                    'm.title_ar as mission_title_ar',
                    'v.title_en as vision_title_en',
                    'v.title_ar as vision_title_ar',
                    'm.is_active as is_active' // if mission is active then vision is also active
                )
                ->where('m.setting_id', $this->settingId)
                ->where('m.company_id', $this->authUser->company_id);

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where(DB::raw('CONCAT(m.id, " - ", v.id)'), 'like', "%$searchValue%")
                    ->orWhere('m.title_en', 'like', "%$searchValue%")
                    ->orWhere('m.title_ar', 'like', "%$searchValue%")
                    ->orWhere('v.title_en', 'like', "%$searchValue%")
                    ->orWhere('v.title_ar', 'like', "%$searchValue%");
                });
            }

            // Clone the query to get the total count before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $missionsAndVisions = $query
                ->offset($start)
                ->limit($length)
                ->orderBy('m.sequence', 'ASC')
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords, // Update this to reflect actual filtered count if needed
                'data' => $missionsAndVisions,
            ]);
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: MissionsAndVisionsController | Function: getPaginatedMissionsAndVisionsData | Code: " . $code . " | Message: " . $msg);

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
            ]);

            // mission
            $missionPicture = $request->file('mission_picture');
            $missionPictureName = Image::savePictureInStorage($missionPicture, $this->imagePath);

            $mission = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('mission_title_en'),
                'title_ar' => $request->get('mission_title_ar'),
                'desc_en' => $request->get('mission_description_en'),
                'desc_ar' => $request->get('mission_description_ar'),
                'picture' => $this->imagePath.$missionPictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $missionId = DB::table($this->missionsAndVisionsMetaData->table_name)
                            ->insertGetId($mission);       

            // vision
            $visionPicture = $request->file('vision_picture');
            $visionPictureName = Image::savePictureInStorage($visionPicture, $this->imagePath);

            $vision = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('vision_title_en'),
                'title_ar' => $request->get('vision_title_ar'),
                'desc_en' => $request->get('vision_description_en'),
                'desc_ar' => $request->get('vision_description_ar'),
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

    public function saveUpdatedMissionAndVision(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'mission_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'mission_title_en' => ['required', 'string', 'max:255'],
                'mission_title_ar' => ['required', 'string', 'max:255'],
                'mission_description_en' => ['required', 'string', 'max:1000'],
                'mission_description_ar' => ['required', 'string', 'max:1000'],

                'vision_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'vision_title_en' => ['required', 'string', 'max:255'],
                'vision_title_ar' => ['required', 'string', 'max:255'],
                'vision_description_en' => ['required', 'string', 'max:1000'],
                'vision_description_ar' => ['required', 'string', 'max:1000'],

                'is_active' => ['required', 'integer'],
            ]);

            $missionId = $request->get('mission_id');
            $mission = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('mission_title_en'),
                'title_ar' => $request->get('mission_title_ar'),
                'desc_en' => $request->get('mission_description_en'),
                'desc_ar' => $request->get('mission_description_ar'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];

            $newMissionPicture = $request->file('mission_picture');
            if($newMissionPicture){
                $missionDBPicture = $request->get('mission_db_picture');
                Image::unlinkPicture($missionDBPicture);
                $newMissionPictureName = Image::savePictureInStorage($newMissionPicture, $this->imagePath);
                $mission['picture'] = $this->imagePath.$newMissionPictureName;
            } 

            $updateMission = DB::table($this->missionsAndVisionsMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $missionId)
                                ->update($mission); 

            $visionId = $request->get('vision_id');
            $vision = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('vision_title_en'),
                'title_ar' => $request->get('vision_title_ar'),
                'desc_en' => $request->get('vision_description_en'),
                'desc_ar' => $request->get('vision_description_ar'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];

            $newVisionPicture = $request->file('vision_picture');
            if($newVisionPicture){

                $visionDBPicture = $request->get('vision_db_picture');
                Image::unlinkPicture($visionDBPicture);
                $newVisionPictureName = Image::savePictureInStorage($newVisionPicture, $this->imagePath);
                $vision['picture'] = $this->imagePath.$newVisionPictureName;
            } 

            $updateVision = DB::table($this->missionsAndVisionsMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $visionId)
                                ->update($vision); 



            if($updateMission == 1 && $updateVision == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.mission_and_vision_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.mission_and_vision_not_updated';
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

            Log::error("Error | Controller: MissionsAndVisionsController | Function: saveUpdatedMissionAndVision | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => $msg], $code);
        }
    }
    
}
