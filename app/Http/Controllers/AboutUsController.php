<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Classes\Image;
use Illuminate\Support\Facades\Crypt;

class AboutUsController extends Controller
{

    private $imagePath = 'images/about-us/';
    private $settingId = 2;
    private $aboutUsMetaData;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->aboutUsMetaData = DB::table('settings_meta_data')
                                    ->where('setting_id', $this->settingId)
                                    ->first();

            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showAboutUs(){
        try{
            return view('about-us.all-about-us');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AboutUsController | Function: showAboutUs | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedAboutUsData(Request $request){
        try{
            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search_value'); // Search value from DataTables


            $query = DB::table($this->aboutUsMetaData->table_name) // Replace with your actual table name
                        ->select('id', 'title_en', 'title_ar', 'is_active')
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

            // Fetch the data with the calculated offset and limit using Query Builder
            $about_us = $query
                            ->offset($start)
                            ->limit($length)
                            ->get()
                            ->map(function ($item) {
                                $item->encrypted_id = Crypt::encrypt($item->id);
                                return $item;
                            });


            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $about_us,
            ]);

        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AboutUsController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showCreateAboutUs(){
        try{
            return view('about-us.create-new-about-us');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AboutUsController | Function: showCreateAboutUs | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedAboutUs(Request $request){
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

            $about_us = [
                'company_id' => $this->authUser->company_id,
                'setting_id' => $this->settingId,
                'title_en' => $request->get('title_en'),
                'title_ar' => $request->get('title_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'picture' => $this->imagePath . $pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insertAboutUs = DB::table($this->aboutUsMetaData->table_name)
                                ->insert($about_us);
            if($insertAboutUs == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.about_us_created';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.about_us_not_created';
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

            Log::error("Error | Controller: AboutUsController | Function: saveCreatedAboutUs | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showAboutUsToUpdate($AboutUsId){
        try{
            $about_us = DB::table($this->aboutUsMetaData->table_name)
                        ->where('company_id', $this->authUser->company_id)
                        ->where('setting_id', $this->settingId)
                        ->where('id', Crypt::decrypt($AboutUsId))
                        ->first();

            return view('about-us.update-about-us', compact('about_us', 'AboutUsId'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: AboutUsController | Function: showAboutUsToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedAboutUs(Request $request){
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

            $aboutUsId = Crypt::decrypt($request->get('about_us_id'));
            $aboutUs = [
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
                $aboutUs['picture'] = $this->imagePath.$pictureName;
            } 

            $updateAboutUs = DB::table($this->aboutUsMetaData->table_name)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('setting_id', $this->settingId)
                                ->where('id', $aboutUsId)
                                ->update($aboutUs);

            if($updateAboutUs == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.about_us_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.about_us_not_updated';
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

            Log::error("Error | Controller: AboutUsController | Function: saveUpdatedAboutUs | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

}
