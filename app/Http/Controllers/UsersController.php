<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Rules\MatchOldPasswordRule;
use App\Rules\UniqueEmailRule;
use Illuminate\Support\Facades\Crypt;
use App\Classes\Image;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;


class UsersController extends Controller
{
    private $imagePath = 'images/users/';

    private $authUser;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->authUser = Auth::user();
            return $next($request);
        });
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect()->route('login'); // Assumes a named route 'login' exists
    }

    public function showUserProfile(){
        try{
            $authUser = $this->authUser;
            return view('user.profile', compact('authUser'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersControllers | Function: showUserProfile | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function updateUserProfile(Request $request)
    {
        try{
            DB::beginTransaction();

            $authUser = $this->authUser;
            $authUserId = $authUser->id;

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', new UniqueEmailRule($authUserId)],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]);
    
            
            $authUser->name = $request->get('name');
            $authUser->email = $request->get('email');
            
            $avatar = $request->file('avatar');
            if ($avatar){
                $userDBPicturePath = $request->get('user_db_picture');
                Image::unlinkPicture($userDBPicturePath);
                $avatarName = Image::savePictureInStorage($avatar, $this->imagePath);
                $authUser->avatar = $this->imagePath.$avatarName;
            }
    
            $isUserUpdated = $authUser->update();
            if ($isUserUpdated) {
                DB::commit();
                $code = 200;
                $msg = 'translation.profile_data_updated';
            } else {
                DB::rollBack();
                $code = 400;
                $msg = 'translation.profile_data_not_updated';
            }
            return response()->json(
                [
                'message' => lang::get($msg)
                ],
                $code); 
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

            Log::error("Error | Controller: UsersControllers | Function: updateUserProfile | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
        
    }

    public function updateUserPassword(Request $request)
    {
        try{
            DB::beginTransaction();
            $authUser = $this->authUser;
            $authUserPassword = $authUser->password;

            $currentPassword = $request->get('current_password');
            $newPassword = $request->get('new_password');

            $request->validate([
                'current_password' => ['required', 'string', new MatchOldPasswordRule],
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
                'new_password_confirmation' => ['required', 'string', 'min:6'],
            ]);
            
            $authUser->password = Hash::make($newPassword);
            $isPassowrdUpdated = $authUser->update();
            if ($isPassowrdUpdated) {
                DB::commit();
                $code = 200;
                $msg = 'translation.password_updated';
                
            } else {
                DB::rollBack();
                $code = 400;
                $msg = 'translation.password_not_updated';
            }
            return response()->json([
                'message' => lang::get($msg)
            ], $code);
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

            Log::error("Error | Controller: UsersControllers | Function: updatePassword | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function updateUserCompanyId(Request $request){
        try{
            DB::beginTransaction();
            $authUser = $this->authUser;
            $authUser->company_id = $request->get('id');
            $updateUser = $authUser->update();
            if($updateUser){
                DB::commit();
                $code = 200;
                $msg = 'translation.company_id_updated';
            }else{
                DB::rollBack();
                $code = 400;
                $msg = 'translation.company_id_not_updated';
            }
            return response()->json(['message' => lang::get($msg)], $code);
        }catch(Exception $e){
            DB::rollBack();

            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersControllers | Function: updateUserCompanyId | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }

    }

    public function showUsers(){
        try{
            return view('users.all-users');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersController | Function: showUsers | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function getPaginatedUsersData(Request $request)
    {
        try {
            $assetUrl = asset('');

            // Get DataTables parameters
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $searchValue = $request->input('search_value'); // Search value from DataTables


            // Base query
            $query = DB::table('users') 
                        ->select('id', 'name', 'email', 'is_active')
                        ->selectRaw("CONCAT('$assetUrl', avatar) AS picture")
                        ->where('company_id', $this->authUser->company_id)
                        ->whereNotIn('type_id', [1]);
                
            // Apply search filter if search value is provided
            if (!empty($searchValue)) {
                $query->where(function($q) use ($searchValue) {
                    $q->where('id', 'like', "%$searchValue%")
                    ->orWhere('name', 'like', "%$searchValue%")
                    ->orWhere('email', 'like', "%$searchValue%");
                });
            }

            // Get the total count of records before applying pagination
            $totalRecords = $query->count();

            // Apply pagination
            $users = $query
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
                'data' => $users,
            ]);
        
        } catch (Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersController | Function: getPaginatedUsersData | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
    }

    public function showCreateUser(){
        try{
            $groups = DB::table('groups')
                        ->where('company_id', $this->authUser->company_id)
                        ->whereNotIn('id', [1])
                        ->get();

            return view('users.create-new-user', compact('groups'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersController | Function: showCreateUser | Code: ".$code." | Message: ".$msg);
            return abort(500);
        }
    }

    public function saveCreatedUser(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'unique:users,email'],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
                'password' => ['required', 'string', 'min:3'],
                'group' => ['required', 'array', 'min:1'], 
                'group.*' => ['exists:groups,id'], 
            ]);
            
            $user = new User;
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->company_id = $this->authUser->company_id;
            $user->type_id = 2;
            $user->created_at = now();
            $user->updated_at = now();
            
            
            $avatar = $request->file('avatar');
            if ($avatar){
                $avatarName = Image::savePictureInStorage($avatar, $this->imagePath);
                $user->avatar = $this->imagePath.$avatarName;
            }

            $isUserInserted = $user->save();

            $groups = $request->get('group');
            $groupsToInsert = [];

            foreach($groups as $group){
                $groupsToInsert[] = [
                    'group_id' => $group,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            $isInsertedUserGroup = DB::table('user_groups')
                                    ->insert($groupsToInsert);
            
            if ($isUserInserted && $isInsertedUserGroup == count($groupsToInsert)) {
                DB::commit();
                $code = 200;
                $msg = 'translation.user_created';
            } else {
                DB::rollBack();
                $code = 400;
                $msg = 'translation.user_not_created';
            }
            return response()->json(
                [
                'message' => lang::get($msg),
                ],
                $code); 
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

            Log::error("Error | Controller: UsersController | Function: saveCreatedUser | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
        
    }

    public function getUserDetails($userId){
        try{
            $userId = Crypt::decrypt($userId);
            $user = DB::table('users')
                        ->where('id', $userId)
                        ->first();
            
            $userGroups = DB::table('user_groups as ug')
                                ->select('g.id', 'g.name', 'ug.is_active')
                                ->leftJoin('groups as g', 'g.id', 'ug.group_id')
                                ->where('ug.user_id', $userId)
                                ->get();
                                        
            $availableCards = DB::table('user_groups_companies_cards as ugcc')
                                ->select('ugcc.menu_id', 's.name_en', 's.name_ar')
                                ->leftJoin('settings as s', 's.id', 'ugcc.menu_id')
                                ->whereIn('ugcc.group_id', $userGroups->pluck('id'))
                                ->get();
        
            return view('users.read-user', compact('user', 'userGroups', 'availableCards'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersController | Function: getUserDetails | Code: ".$code." | Message: ".$msg);
            return abort(500);
            
        }
    }

    public function showUserToUpdate($userId){
        try{
            $user = DB::table('users')
                        ->where('id', Crypt::decrypt($userId))
                        ->first();
            
            $groups = DB::table('groups')
                        ->where('company_id', $this->authUser->company_id)
                        ->get();

            $userGroupsId = DB::table('user_groups')
                                ->where('user_id', Crypt::decrypt($userId))
                                ->pluck('group_id')
                                ->toArray();
        
            return view('users.update-user', compact('user', 'groups', 'userGroupsId', 'userId'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UsersController | Function: showUserToUpdate | Code: ".$code." | Message: ".$msg);
            return abort(500);
            
        }
    }

    public function saveUpdatedUser(Request $request){
        try{
            DB::beginTransaction();
            $request->validate([
                'is_active' => ['required', 'integer'],
                'group' => ['required', 'array', 'min:1'], 
                'group.*' => ['exists:groups,id'], 
            ]);
            
            $userId = Crypt::decrypt($request->get('user_id'));
            $user = User::find($userId);
            $user->is_active = $request->get('is_active');
            $user->updated_at = now();
            $isUserUpdate = $user->update();
            
            DB::table('user_groups')
                ->where('user_id', $userId)
                ->delete();

            $groups = $request->get('group');
            $groupsToInsert = [];

            foreach($groups as $group){
                $groupsToInsert[] = [
                    'group_id' => $group,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            $isInsertedUserGroup = DB::table('user_groups')
                                    ->insert($groupsToInsert);
            
            if ($isUserUpdate && $isInsertedUserGroup == count($groupsToInsert)) {
                DB::commit();
                $code = 200;
                $msg = 'translation.user_updated';
            } else {
                DB::rollBack();
                $code = 400;
                $msg = 'translation.user_not_updated';
            }
            return response()->json(
                [
                'message' => lang::get($msg),
                ],
                $code); 
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

            Log::error("Error | Controller: UsersController | Function: saveUpdatedUser | Code: ".$code." | Message: ".$msg);
            return response()->json(['message' => $msg], $code);
        }
        
    }
}
