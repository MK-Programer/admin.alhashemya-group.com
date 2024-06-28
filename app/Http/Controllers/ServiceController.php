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

class ServiceController extends Controller
{

    private $imagePath = 'images/services/';
    private $settingId = 1;
    private $servicesMetaData;
    private $services;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->servicesMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();
            $this->services = DB::table($this->servicesMetaData->table_name)
                            ->where('setting_id', $this->settingId)
                            ->where('company_id', $this->authUser->company_id)
                            ->orderBy('sequence', 'ASC')
                            ->get();
            return $next($request);
        });
        
        
    }

    public function showServices(){
        try{
            $services = json_encode($this->services, true);
            return view('services.services', compact('services'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServiceController | Function: showServices | Code: ".$code." | Message: ".$msg);
            return view('errors.500');
        }
    }

    
    // public function updateServices(Request $request) {
    //     try {
    //         // return response()->json($request, 500);
    //         DB::beginTransaction();
    //         $authUser = Auth::user();
    //         $authUserCompanyId = $authUser->company_id;
    
    //         $ids = $request->get('id');  
    //         $dbPictures = $request->get('hidden_picture');
    //         $newPictures = $request->file('new_picture'); // Use file() to get files
    //         $titlesEn = $request->get('title_en');
    //         $titlesAr = $request->get('title_ar');
    //         $descriptionsEn = $request->get('description_en');
    //         $descriptionsAr = $request->get('description_ar');
    //         $sequences = $request->get('sequence');
            
    //         // Validate $request inputs and handle any validation errors from front-end
    
    //         $servicesFailure = [];
            
    //         for ($i = 0; $i < count($ids); $i++) {
    //             if ($ids[$i] == null) {
    //                 $file = $newPictures[$i];
                    
    //                 $newPictureName = time() . '.' . $file->getClientOriginalExtension();
    //                 $picturesPath = public_path($this->imgPath);
    //                 $file->move($picturesPath, $newPictureName);

    //                 $service = [
    //                     'company_id' => $authUserCompanyId,
    //                     'setting_id' => $this->settingId,
    //                     'title_en' => $titlesEn[$i],
    //                     'title_ar' => $titlesAr[$i],
    //                     'desc_en' => $descriptionsEn[$i],
    //                     'desc_ar' => $descriptionsAr[$i],
    //                     'sequence' => $sequences[$i],
    //                     'picture' => '$this->imgPath.$newPictureName',
    //                     'created_at' => now(),
    //                     'updated_at' => now()
    //                 ];

    //                 $isFailure = DB::table($this->servicesMetaData->table_name)
    //                                 ->insert($service);
                                        
                
    //             } else {
    //                 // Handle existing service row update
    //                 $service = [
    //                     'title_en' => $titlesEn[$i],
    //                     'title_ar' => $titlesAr[$i],
    //                     'desc_en' => $descriptionsEn[$i],
    //                     'desc_ar' => $descriptionsAr[$i],
    //                     'sequence' => $sequences[$i],
    //                     'updated_at' => now()
    //                 ];
                
    //                 if ($newPictures[$i]) {
    //                     // Delete existing image
    //                     $imagePath = public_path($dbPictures[$i]);
    //                     if (file_exists($imagePath)) {
    //                         unlink($imagePath);
    //                     }
                
    //                     // Upload new image
    //                     $file = $newPictures[$i];
    //                     $newPictureName = time() . '.' . $file->getClientOriginalExtension();
    //                     $file->move(public_path($this->imgPath), $newPictureName);
                
    //                     $service['picture'] = $this->imgPath . $newPictureName;
    //                 }
                
    //                 $isFailure = DB::table($this->servicesMetaData->table_name)
    //                                 ->where('id', $ids[$i])
    //                                 ->update($service);
    //             }
                
    
    //             if ($isFailure != 1) {
    //                 $servicesFailure[] = $i;
    //             }
    //         }
    
    //         if (count($servicesFailure) == 0) {
    //             DB::commit();
    //             $response = ['message' => Lang::get('translation.services_created_update_success')];
    //             $code = 200;
    //         } else {
    //             DB::rollBack();
    //             $response = ['message' => Lang::get('translation.services_created_update_failure')];
    //             $code = 400;
    //         }
    
    //         return response()->json($response, $code);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    
    //         $code = $e->getCode();
    //         $msg = $e->getMessage();
    
    //         Log::error("Error | Controller: ServiceController | Function: updateServices | Code: ".$code." | Message: ".$msg);
    
    //         return response()->json(['message' => $msg], $code);
    //     }
    // }

    private function deleteExistServices($reusedPictures){
        for($i = 0; $i < count($this->services); $i++){
            $imagePath = public_path($this->services[$i]->picture);
            if (file_exists($imagePath) && !in_array($this->services[$i]->picture, $reusedPictures)) {
                unlink($imagePath);
            }
        }

    }

    public function updateServices(Request $request)
    {
        try {
            DB::beginTransaction();

            $ids = $request->get('id');  
            $dbPictures = $request->get('hidden_picture');
            $newPictures = $request->file('new_picture'); // Ensure $newPictures is an array
            $titlesEn = $request->get('title_en');
            $titlesAr = $request->get('title_ar');
            $descriptionsEn = $request->get('description_en');
            $descriptionsAr = $request->get('description_ar');
            $sequences = $request->get('sequence');
            
            
        DB::table($this->servicesMetaData->table_name)
        ->where('setting_id', $this->settingId)
        ->delete();

            $services = [];
            $reusedPictures = [];
            for ($i = 0; $i < count($ids); $i++) {
                $newPictures[$i] = $newPictures[$i] ?? null;
                
                $uuid = Str::uuid(); 
                $file = $newPictures[$i];
                // if($i == 2){
                //     return response()->json($file, 500);
                // }

                if ($file != null) {
                    $newPictureName = $uuid . '.'. $file->getClientOriginalExtension();
                    
                    $picturePath = public_path($this->imagePath);
                    
                    $file->move($picturePath, $newPictureName);
                
                    $picture = $this->imagePath.$newPictureName;
                }else{
                    $reusedPictures[] = $dbPictures[$i]; 
                    $picture = $dbPictures[$i];
                }
                
                
                $services[] = [
                    'company_id' => $this->authUser->company_id,
                    'setting_id' => $this->settingId,
                    'title_en' => $titlesEn[$i],
                    'title_ar' => $titlesAr[$i],
                    'desc_en' => $descriptionsEn[$i],
                    'desc_ar' => $descriptionsAr[$i],
                    'sequence' => $sequences[$i],
                    'picture' => $picture,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
            }
            
            $insertServices = DB::table("company_settings_data_rel")
                                ->insert($services);
            $this->deleteExistServices($reusedPictures);
                
            if ($insertServices == count($services)) {
                DB::commit();
                $response = ['message' => Lang::get('translation.services_created_update_success')];
                $code = 200;
            } else {
                DB::rollBack();
                $response = ['message' => Lang::get('translation.services_created_update_failure')];
                $code = 400;
            }

            return response()->json($response, $code);
        } catch (Exception $e) {
            DB::rollBack();

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServiceController | Function: updateServices | Code: ".$code." | Message: ".$msg);

            return response()->json($request, $code);
        }
    }
    
    

    
}
