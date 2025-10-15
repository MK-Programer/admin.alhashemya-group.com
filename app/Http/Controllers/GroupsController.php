<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;

class GroupsController extends Controller{
    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function showGroups(){
        try{
            return view('groups.all-groups');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: GroupsController | Function: showGroups | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedGroupsData(Request $request){
        try {
            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search_value'); // Search value from DataTables

            // Base query
            $query = DB::table('groups')
                        ->select('id', 'name', 'is_active')
                        ->where('company_id', $this->authUser->company_id);
            
            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('name', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $groups = $query
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
                'data' => $groups,
            ]);
        
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: GroupsController | Function: getPaginatedGroupsData | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function getRelatedMenu(){
        $columnLang = app()->getLocale() == 'en' ? 'settings.name_en' : 'settings.name_ar';
        $menu = DB::table('settings')
                        ->select('id', $columnLang.' as name');
        if($this->authUser->company_id == 3){
            $menu = $menu->whereNotIn('id', [8]);
        }
        $menu = $menu->orderBy('sequence', 'ASC')->get();
        return $menu;
    }

    public function showCreateGroup(){
        try{
            $menu = $this->getRelatedMenu();
            return view('groups.create-new-group', compact('menu'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: GroupsController | Function: showCreateGroup | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedGroup(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'menu' => ['required', 'array', 'min:1'], 
                'menu.*' => ['exists:settings,id'], 
            ]);

            $group = [
                'name' => $request->get('name'),
                'company_id' => $this->authUser->company_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $insertGroupGetId = DB::table('groups')
                                ->insertGetId($group);  

            $menus = $request->get('menu');
            $cards = [];
            foreach($menus as $menu){
                $cards[] = [
                    'group_id' => $insertGroupGetId,
                    'menu_id' => $menu,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }   

            $insertUserGroupCompanyCards = DB::table('user_groups_companies_cards')
                                                ->insert($cards);

            if($insertGroupGetId >= 1 && $insertUserGroupCompanyCards == count($cards)){
                DB::commit();
                $code = 200;
                $msg = 'translation.group_created';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.group_not_created';
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

            Log::error("Error | Controller: GroupsController | Function: saveCreatedGroup | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showGroupToUpdate($groupId){
        try{
            $group = DB::table('groups')
                        ->where('id', Crypt::decrypt($groupId))
                        ->first();

            $menu = $this->getRelatedMenu();

            $selectedMenusIds = DB::table('user_groups_companies_cards as ugcc')
                        ->leftJoin('settings as s', 's.id', 'ugcc.menu_id')
                        ->where('ugcc.group_id', Crypt::decrypt($groupId))
                        ->where('is_active', 1)
                        ->pluck('ugcc.menu_id')
                        ->toArray();


            return view('groups.update-group', compact('group', 'menu', 'selectedMenusIds', 'groupId'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: GroupsController | Function: showGroupToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveUpdatedGroup(Request $request){
        try{
            DB::beginTransaction();
            
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'menu' => ['required', 'array', 'min:1'], 
                'menu.*' => ['exists:settings,id'], 
                'is_active' => ['required', 'integer'],
            ]);
            
            $groupId = Crypt::decrypt($request->get('group_id'));
            $group = [
                'name' => $request->get('name'),
                'is_active' => $request->get('is_active'),
                'updated_at' => now(),
            ];

            $updateGroup = DB::table('groups')
                                ->where('id', $groupId)
                                ->update($group); 
            
            $menus = $request->get('menu');
                
            $existingCards = DB::table('user_groups_companies_cards')
                                ->where('group_id', $groupId)
                                ->pluck('menu_id')
                                ->toArray();

            $cardsCouldBeDeactivatedCount = DB::table('user_groups_companies_cards')
                                                ->where('group_id', $groupId)
                                                ->whereNotIn('menu_id', $menus)
                                                ->update(
                                                    [
                                                        'is_active' => 0,
                                                        'updated_at' => now()
                                                    ]
                                                );
                                                
            // Separate cards to insert and update
            $cardsToInsert = [];
            $cardsToUpdate = [];

            foreach ($menus as $menuId) {
                if (in_array($menuId, $existingCards)) {
                    $cardsToUpdate[] = $menuId;
                } else {
                    $cardsToInsert[] = [
                        'group_id' => $groupId,
                        'menu_id' => $menuId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            $updateUserGroupCompanyCardsCount = 0;
            $insertUserGroupCompanyCardsCount = 0;
            // Perform batch updates for existing cards
            if (!empty($cardsToUpdate)) {
                $updateUserGroupCompanyCardsCount = DB::table('user_groups_companies_cards')
                                                    ->where('group_id', $groupId)
                                                    ->whereIn('menu_id', $cardsToUpdate)
                                                    ->update([
                                                        'is_active' => 1,
                                                        'updated_at' => now(),
                                                    ]);
            }

            // Perform batch inserts for new cards
            if (!empty($cardsToInsert)) {
                $insertUserGroupCompanyCardsCount = DB::table('user_groups_companies_cards')->insert($cardsToInsert);
            }
            
            if($updateGroup == 1 && ($cardsCouldBeDeactivatedCount + $updateUserGroupCompanyCardsCount + $insertUserGroupCompanyCardsCount)== count($existingCards)){
                DB::commit();
                $code = 200;
                $msg = 'translation.group_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.group_not_updated';
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

            Log::error("Error | Controller: GroupsController | Function: saveUpdatedGroup | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }
}
