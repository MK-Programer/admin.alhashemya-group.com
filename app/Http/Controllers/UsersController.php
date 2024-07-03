<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use App\Rules\MatchOldPasswordRule;
use App\Rules\UniqueEmailRule;
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

            return response()->json(['message' => lang::get('translation.error_500')], $code);
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

            return response()->json(['message' => lang::get('translation.error_500')], $code);
        }
    }

    public function getUserCompanies(){
        $companies = DB::table('companies')
                        ->where('is_active', 1)
                        ->get();

        return $companies;
        
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

            return response()->json(['message' => lang::get('translation.error_500')], $code);
        }

    }

}
