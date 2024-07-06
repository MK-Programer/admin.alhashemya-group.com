<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Classes\Image;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    private $imagePath = 'images/companies/';
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {


            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showCompany(){
        try{
            return view('companies.all-companies');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CompanyController | Function: showCompany | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function showCreateCompany(){
        try{
            return view('companies.create-new-company');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: HomeController | Function: showCreateCompany | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }
    public function saveCreatedCompany(Request $request)
    {

        // dd(44);
        try{
            DB::beginTransaction();

            $request->validate([
                'picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'email' => ['nullable','email', 'max:30'],
                'phone' => ['required', 'regex:/^[0-9]{9,15}$/', 'numeric'],


            ]);

            $picture = $request->file('picture');
            $pictureName = Image::savePictureInStorage($picture, $this->imagePath);

            $company = [
                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'fb_link' => $request->get('fb_link'),
                'other_link' => $request->get('other_link'),
                'is_active' => 1,
                'logo' => $this->imagePath . $pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];


            // return response()->json(['message' => $company], 200);


            // dd(4);
            $insert_company = DB::table('companies')
                                ->insert($company);


            if($insert_company == 1){
                DB::commit();
                $code = 200;
                $msg = lang::get('translation.company_created');
            }else{
                DB::rollBack();
                $code = 400;
                $msg = lang::get('translation.company_not_created');
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

            Log::error("Error | Controller: CompanyController | Function: savecreatedCompany | Code: ".$code." | message: ".$msg);
        }
    }


    public function getPaginatedCompanyData(Request $request){
        try{

            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables

            // Base query
            $query = DB::table('companies') // Replace with your actual table name
                        ->select('id', 'name_en', 'name_ar', 'logo', 'phone' , 'email', 'fb_link', 'other_link','is_active')
                        ->selectRaw("CONCAT('$assetUrl', logo) AS picture")
                        ->where('id', $this->authUser->company_id);

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('name_en', 'like', "%$searchValue%")
                    ->orWhere('name_ar', 'like', "%$searchValue%")
                    ->orWhere('phone', 'like', "%$searchValue%")
                    ->orWhere('email', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $company = $query
                ->offset($start)
                ->limit($length)
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $company,
            ]);
        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CompanyController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);
        }
    }

    public function showCompanyToUpdate($companyId){
        try{
            $company = DB::table('companies')
                        ->where('id', $companyId)
                        ->first();

            return view('companies.update-company', compact('company'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CompanyController | Function: showCompanyToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedCompany(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'is_active' => ['required', 'integer'],
                'email' => ['email', 'max:255'],
                'phone' => ['integer'],
            ]);

            $companyId = $request->get('company_id');
            $company = [

                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'fb_link' => $request->get('fb_link'),
                'other_link' => $request->get('other_link'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];

            $newPicture = $request->file('picture');
            if($newPicture){

                $dbPicture = $request->get('db_picture');
                Image::unlinkPicture($dbPicture);
                
                $pictureName = Image::savePictureInStorage($newPicture, $this->imagePath);
                $company['logo'] = $this->imagePath.$pictureName;
            } 

            $updateCompany = DB::table('companies')
                                ->where('id', $companyId)
                                ->update($company);

            if($updateCompany == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.company_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.company_not_updated';
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

            Log::error("Error | Controller: CompanyController | Function: saveUpdatedCompany | Code: ".$code." | Message: ".$msg);

        }
    }


}
