<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
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
            $uuid = Str::uuid();
            $picture = $request->file('picture');
            $pictureName = $uuid . '.' . $picture->getClientOriginalExtension();
            $picturePath = public_path($this->imagePath);
            $picture->move($picturePath, $pictureName);

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

            return response()->json(['message' => $msg], $code);
        }
    }


    public function getPaginatedCompanyData(Request $request){
        try{
            $assetUrl = asset('');

            // Number of records to fetch per request
            $perPage = 10;

            // Get the current page from the request, default is 1
            $currentPage = $request->input('page', 1);

            // Calculate the offset
            $offset = ($currentPage - 1) * $perPage;

            // Fetch the data with the calculated offset and limit using Query Builder
            $company = DB::table('companies') // Replace with your actual table name
                            ->select('id', 'name_en', 'name_ar', 'logo', 'phone' , 'email', 'fb_link', 'other_link','is_active')
                            ->selectRaw("CONCAT('$assetUrl', logo) AS picture")
                            ->offset($offset)
                            ->limit($perPage)
                            ->get();
            // return $company;

            // Count total records
            $totalRecords = DB::table('companies')
                                    ->count();

            // Calculate total pages
            $totalPages = ceil($totalRecords / $perPage);

            return response()->json([
                'data' => $company,
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'per_page' => $perPage,
            ]);

        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CompanyController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => $msg], $code);
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
                $dbPicturePath = public_path($dbPicture);
                if (file_exists($dbPicturePath)) {
                    unlink($dbPicturePath);
                }

                $uuid = Str::uuid();

                $pictureName = $uuid . '.' . $newPicture->getClientOriginalExtension();
                $picturePath = public_path($this->imagePath);
                $newPicture->move($picturePath, $pictureName);
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

            return response()->json(['message' => $msg], $code);
        }
    }


}
