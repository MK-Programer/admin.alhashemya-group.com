<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class CategoryController extends Controller
{
    private $table_name;
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->table_name = 'categories';

            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showCategories(){
        try{
            return view('categories.all-categories');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CategoryController | Function: showCategories | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedcategoriesData(Request $request){
        try{

            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search.value'); // Search value from DataTables

            // Base query
            $query = DB::table($this->table_name) // Replace with your actual table name
                        ->select('id', 'name_en', 'name_ar', 'is_active');

            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('name_en', 'like', "%$searchValue%")
                    ->orWhere('name_ar', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $categories = $query
                ->offset($start)
                ->limit($length)
                ->get();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $categories,
            ]);
        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CategoryController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showCreateCategory(){
        try{
            return view('categories.create-new-category');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CategoryController | Function: showCreateCategory | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedCategory(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],

            ]);

            $category = [
                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            

            $insertcategory = DB::table($this->table_name)
                                ->insert($category);
                                
            if($insertcategory == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.category_created';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.category_not_created';
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

            Log::error("Error | Controller: CategoryController | Function: saveCreatedCategory | Code: ".$code." | Message: ".$msg);

        }
    }

    public function showCategoryToUpdate($categoryId){
        try{
            $category = DB::table($this->table_name)
                        ->where('id', $categoryId)
                        ->first();

            return view('categories.update-category', compact('category'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: CategoryController | Function: showCategoryToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedCategory(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'is_active' => ['required', 'integer'],
            ]);

            $categoryId = $request->get('category_id');
            $category = [
                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];



            $updatecategory = DB::table($this->table_name)
                                ->where('id', $categoryId)
                                ->update($category);

            if($updatecategory == 1){
                DB::commit();
                $code = 200;
                $msg = 'translation.category_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.category_not_updated';
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

            Log::error("Error | Controller: CategorysController | Function: saveUpdatedCategory | Code: ".$code." | Message: ".$msg);

        }
    }

}
