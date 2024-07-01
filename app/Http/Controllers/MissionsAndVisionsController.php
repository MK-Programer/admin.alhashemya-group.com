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
    
}
