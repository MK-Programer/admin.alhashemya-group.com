<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class ServiceController extends Controller
{
    public function showServices(){
        try{
            $services = [
                // ['id' => 1, 'picture' => asset('images/avatar-1.jpg'), 'title_en' => 'title_en_1', 'title_ar' => 'title_ar_1', 'description_en' => 'description_en_1', 'description_ar' => 'description_ar_1', 'sequence' => '1'],
                // ['id' => 2, 'picture' => asset('images/avatar-1.jpg'), 'title_en' => 'title_en_2', 'title_ar' => 'title_ar_2', 'description_en' => 'description_en_2', 'description_ar' => 'description_ar_2', 'sequence' => '2'],
                // ['id' => 3, 'picture' => asset('images/avatar-1.jpg'), 'title_en' => 'title_en_3', 'title_ar' => 'title_ar_3', 'description_en' => 'description_en_3', 'description_ar' => 'description_ar_3', 'sequence' => '3'],
            ];
            $services = json_encode($services, true);
            return view('services.services', compact('services'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServiceController | Function: showServices | Code: ".$code." | Message: ".$msg);
            return view('errors.500');
        }
    }

    
    public function updateServices(Request $request){
        
        try{
            DB::beginTransaction();
            
            $ids = $request->get('id');
            $dbPictures = $request->get('hidden_picture');
            $newPictures = $request->get('new_picture');
            $titlesEn = $request->get('title_en');
            $titlesAr = $request->get('title_ar');
            $descriptionsEn = $request->get('description_en');
            $descriptionsAr = $request->get('description_ar');
            $sequences = $request->get('sequence');

            $servicesToCreate = [];
            for($i = 0; $i < count($ids); $i++){

                // new row to create
                if($ids[$i] == null){
                    $services[] = [
                        'title_en' => $titlesEn[$i],
                        'title_ar' => $titlesAr[$i],
                        'description_en' => $descriptionsEn[$i],
                        'description_ar' => $descriptionsAr[$i],
                        'sequence' => $sequences[$i],
                        'picture' => $newPictures[$i],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                // exist row to update
                else{

                }
            }
            return response()->json($request);
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

            Log::error("Error | Controller: ServiceController | Function: updateServices | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => lang::get('translation.error_500')], $code);
        
        }
    }
}
