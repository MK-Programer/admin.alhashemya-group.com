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

class ServicesController extends Controller
{

    private $imagePath = 'images/services/';
    private $settingId = 1;
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
            return view('errors.500');
        }
    }

    public function getPaginatedServicesData(Request $request){
        try{
            $assetUrl = asset('');

            // Number of records to fetch per request
            $perPage = 10;

            // Get the current page from the request, default is 1
            $currentPage = $request->input('page', 1);

            // Calculate the offset
            $offset = ($currentPage - 1) * $perPage;

            // Fetch the data with the calculated offset and limit using Query Builder
            $services = DB::table($this->servicesMetaData->table_name) // Replace with your actual table name
                            ->select('id', 'title_en', 'title_ar', 'desc_en', 'desc_ar', 'sequence')
                            ->selectRaw("CONCAT('$assetUrl', picture) AS picture")
                            ->where('setting_id', $this->settingId)
                            ->where('company_id', $this->authUser->company_id)
                            ->where('is_deleted', 0)
                            ->offset($offset)
                            ->limit($perPage)
                            ->get();

            // Count total records
            $totalRecords = DB::table($this->servicesMetaData->table_name) 
                                    ->where('setting_id', $this->settingId)
                                    ->where('company_id', $this->authUser->company_id)
                                    ->count();

            // Calculate total pages
            $totalPages = ceil($totalRecords / $perPage);

            return response()->json([
                'data' => $services,
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'per_page' => $perPage,
            ]);
        
        }catch(Exception $e){

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => $msg], $code);
        }
    }

    public function deleteService($serviceId){
        try{
            DB::beginTransaction();
            $deleteService = DB::table($this->servicesMetaData->table_name) 
                                ->where('setting_id', $this->settingId)
                                ->where('company_id', $this->authUser->company_id)
                                ->where('id', $serviceId)
                                ->update(['is_deleted' => 1, 'updated_at' => now()]);

            if($deleteService == 1){
                DB::commit();
                $code = 200;
                $msg = lang::get('translation.service_deleted');
            }else{
                DB::rollBack();
                $code = 400;
                $msg = lang::get('translation.service_not_deleted');
            }
            return response()->json(['message' => $msg], $code);
        }catch(Exception $e){
            DB::rollBack();
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: ServicesController | Function: getPaginatedData | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => $msg], $code);
        }
    }

}
