<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Classes\Image;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    private $imagePath = 'images/products/';
    private $tableName;
    private $authUser;


    public function __construct(){
        $this->middleware(function ($request, $next) {

            $this->tableName = 'products';
            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showProducts(){
        try{
            return view('products.all-products');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ProductsController | Function: showProduct | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedProductsData(Request $request){
        try{


            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search_value'); // Search value from DataTables

            // Base query
            $query = DB::table($this->tableName) // Replace with your actual table name
                        ->select('id', 'name_en', 'name_ar', 'is_active')
                        ->selectRaw("CONCAT('$assetUrl', picture) AS picture")
                        ->where('company_id', $this->authUser->company_id);

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
            $products = $query
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
                'data' => $products,
            ]);
            

        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ProductsController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showCreateProduct(){
        try{
            $categories = DB::table('categories')->get();
            return view('products.create-new-product', compact('categories'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ProductsController | Function: showCreateProduct | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedProduct(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
                'code' => ['required', 'max:255'],
                'category_id' => ['required'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
                'model' => ['required', 'max:255'],
                'voltage' => ['required', 'max:255'],
                'width' => ['required', 'max:255'],
                'height' => ['required', 'max:255'],
                'capacity' => ['required', 'max:255'],
                'length' => ['required', 'max:255'],
                'total_height' => ['required', 'max:255'],
                'gross_weight' => ['required', 'max:255'],
            ]);

            $picture = $request->file('picture');
            $pictureName = Image::savePictureInStorage($picture, $this->imagePath);

            $product = [
                'company_id' => $this->authUser->company_id,
                'category_id' =>$request->get('category_id'),
                'product_code' => $request->get('code'),
                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'picture' => $this->imagePath . $pictureName,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $product_id = DB::table($this->tableName)
                                ->insertGetId($product);

            $product_details = [
                'product_id' => $product_id,
                'model' => $request->get('model'),
                'voltage' => $request->get('voltage'),
                'capacity' => $request->get('capacity'),
                'width' => $request->get('width'),
                'height' => $request->get('height'),
                'length' => $request->get('length'),
                'total_height' => $request->get('total_height'),
                'gross_weight' => $request->get('gross_weight'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insert_details = DB::table('product_details')
                        ->insert($product_details);

            if($product_id >=1 && $insert_details == 1 ){
                DB::commit();
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.product_not_created';
                return response()->json(['message' => lang::get($msg)], $code);
            }
            if($request->applications !=null){
                foreach ($request->applications as $key => $app) {
                    if($app['application'] != null){
                        $application = [
                            'product_id' => $product_id,
                            'type' => 'application',
                            'name_en' => $app['application'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $insert_application = DB::table('product_info')
                                                ->insert($application);

                        if($insert_application == 1){
                            DB::commit();
                        }else{
                            DB::rollBack();
                            $code = 400;
                            $msg = 'translation.product_not_created';
                            return response()->json(['message' => lang::get($msg)], $code);
                        }

                    }
                }
            }


            if($request->features !=null){
                foreach ($request->features as $key => $user_feature) {
                    if($user_feature['feature'] != null){
                        $feature = [
                            'product_id' => $product_id,
                            'type' => 'feature',
                            'name_en' => $user_feature['feature'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $insert_feature = DB::table('product_info')
                                                ->insert($feature);

                        if($insert_feature == 1){
                            DB::commit();
                        }else{
                            DB::rollBack();
                            $code = 400;
                            $msg = 'translation.product_not_created';
                            return response()->json(['message' => lang::get($msg)], $code);
                        }
                    }
                }
            }


            $code = 200;
            $msg = 'translation.product_created';
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

            return $msg;

            Log::error("Error | Controller: ProductsController | Function: saveCreatedProduct | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showProductToUpdate($productId){
        try{
            $product = DB::table($this->tableName)
                            ->select('products.*', 'pd.*','c.name_en as category_name_en')
                            ->leftJoin('product_details as pd', 'pd.product_id', '=', 'products.id')
                            ->leftJoin('categories as c', 'products.category_id', '=', 'c.id')
                            ->where('products.company_id', $this->authUser->company_id)
                            ->where('products.id', Crypt::decrypt($productId))
                            ->first();

            // Step 2: Retrieve the related product_info data
            $productInfos = DB::table('product_info')
                            ->select('name_en as info', 'type')
                            ->where('product_id', Crypt::decrypt($productId))
                            ->get();

            // Step 3: Combine the product data with the product_info data
            if ($product) {
                $product->infos = $productInfos;
            }

            // return $product;

            $categories = DB::table('categories')->get();

            return view('products.update-product', compact('product','categories', 'productId'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ProductsController | Function: showProductToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedProduct(Request $request){
        try{
            DB::beginTransaction();

            $request->validate([
                'code' => ['required', 'max:255'],
                'category_id' => ['required'],
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['required', 'string', 'max:255'],
                'description_en' => ['required', 'string', 'max:1000'],
                'description_ar' => ['required', 'string', 'max:1000'],
                'model' => ['required', 'max:255'],
                'voltage' => ['required', 'max:255'],
                'width' => ['required', 'max:255'],
                'height' => ['required', 'max:255'],
                'capacity' => ['required', 'max:255'],
                'length' => ['required', 'max:255'],
                'total_height' => ['required', 'max:255'],
                'gross_weight' => ['required', 'max:255'],
            ]);


            $productId = Crypt::decrypt($request->get('product_id'));
            $product = [
                'company_id' => $this->authUser->company_id,
                'category_id' =>$request->get('category_id'),
                'product_code' => $request->get('code'),
                'name_en' => $request->get('name_en'),
                'name_ar' => $request->get('name_ar'),
                'desc_en' => $request->get('description_en'),
                'desc_ar' => $request->get('description_ar'),
                'updated_at' => now(),
            ];

            $newPicture = $request->file('picture');
            if($newPicture){

                $dbPicture = $request->get('db_picture');
                if($dbPicture){    
                    Image::unlinkPicture($dbPicture);
                }
                
                $pictureName = Image::savePictureInStorage($newPicture, $this->imagePath);
                $product['picture'] = $this->imagePath.$pictureName;
            } 

            $updateproduct = DB::table($this->tableName)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('id', $productId)
                                ->update($product);

            if($updateproduct == 1 ){
                DB::commit();
                $code = 200;
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.product_not_updated';
                return response()->json(['message' => lang::get($msg)], $code);
            }

            $product_details = [
                'model' => $request->get('model'),
                'voltage' => $request->get('voltage'),
                'capacity' => $request->get('capacity'),
                'width' => $request->get('width'),
                'height' => $request->get('height'),
                'length' => $request->get('length'),
                'total_height' => $request->get('total_height'),
                'gross_weight' => $request->get('gross_weight'),
                'updated_at' => now(),
            ];

        //    return  $request->get('model');

            $update_product_details = DB::table('product_details')
                                        ->where('product_id', $productId)
                                        ->update($product_details);

            // return $update_product_details;


            if($update_product_details == 1 ){
                DB::commit();
                $code = 200;
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.product_not_updated';
                return response()->json(['message' => lang::get($msg)], $code);
            }


            $productInfos = DB::table('product_info')
            ->select('name_en as info', 'type')
            ->where('product_id', $productId)
            ->get();

            foreach ($productInfos as $key => $value) {

                if($value->type == 'application'){
                    $old_application_with_key = 'old_application_'. $key;  //old_application_2

                    $update_old_app = $request->input($old_application_with_key);


                    $old_application = [
                        'product_id' => $productId,
                        'type' => 'application',
                        'name_en' => $update_old_app,

                    ];

                    $update_application = DB::table('product_info')
                                            ->where('product_id', $productId)
                                            ->where('type', 'application')
                                            ->where('name_en' , $value->info)
                                            ->update($old_application);

                }
            }


                foreach ($productInfos as $key => $value) {

                    if($value->type == 'feature'){
                        $old_feature_with_key = 'old_feature_'.$key;

                        $update_old_app = $request->input($old_feature_with_key);

                        $old_feature = [
                            'product_id' => $productId,
                            'type' => 'feature',
                            'name_en' => $update_old_app,

                        ];

                        $update_feature = DB::table('product_info')
                                                ->where('product_id', $productId)
                                                ->where('type', 'feature')
                                                ->where('name_en' , $value->info)
                                                ->update($old_feature);


                    }
                }




            $apps = [];
            foreach ($request->applications as $key => $value) {
                if($value['application'] != null){
                    $apps[] = $value['application'];
                }
            }

            foreach ($apps as  $app) {
               $update_app =  DB::table('product_info')
                    ->insert([
                        'product_id' => $productId,
                        'type' => 'application',
                        'name_en' => $app
                    ]);
            }

            $features = [];
            foreach ($request->features as $key => $value) {
                if($value['feature'] != null){
                    $features[] = $value['feature'];
                }
            }

            foreach ($features as  $feat) {
               $update_feat =  DB::table('product_info')
                    ->insert([
                        'product_id' => $productId,
                        'type' => 'feature',
                        'name_en' => $feat
                    ]);
            }


                $code = 200;
                $msg = 'translation.product_updated';
                // return redirect()->back()->with('message', lang::get($msg));
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

            Log::error("Error | Controller: ProductsController | Function: saveUpdatedProduct | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

}
