<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Log;
use Exception;
use DB;


class UserController extends Controller
{
    public function showUserProfile(){
        try{
            $authUser = Auth::user();
            return view('user.profile', compact('authUser'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UserController | Function: showUserProfile | Code: ".$code." | Message: ".$msg);
            return view('errors.500');
        }
    }

    public function updateUserProfile(Request $request)
    {
        try{
            DB::beginTransaction();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'unique:users,email'],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]);
    
            $authUser = Auth::user();
            $authUser->name = $request->get('name');
            $authUser->email = $request->get('email');
    
            if ($request->file('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/images/');
                $avatar->move($avatarPath, $avatarName);
                $authUser->avatar = '/images/' . $avatarName;
            }
    
            $isUserUpdated = $authUser->update();
            if ($isUserUpdated) {
                DB::commit();
                return response()->json(
                    [
                    'message' => lang::get('translation.profile_data_updated') 
                    ],
                     200); 
            } else {
                DB::rollBack();
                return response()->json(
                    [
                    'message' => lang::get('translation.profile_data_not_updated') 
                    ],
                    400);
            }
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

            Log::error("Error | Controller: UserController | Function: updateUserProfile | Code: ".$code." | Message: ".$msg);

            return response()->json(lang::get('translation.error_500'), $code);
        }
        
    }

    public function updateUserPassword(Request $request)
    {
        try{
            DB::beginTransaction();
            $authUser = Auth::user();
            $authUserPassword = $authUser->password;

            $currentPassword = $request->get('current-password');
            $newPassword = $request->get('new-password');

            $request->validate([
                'current-password' => ['required', 'string'],
                'new-password' => ['required', 'string', 'min:6', 'confirmed'],
                'new-password_confirmation' => ['required', 'string', 'min:6'],
            ]);
            $matchCurrentPassword = Hash::check($currentPassword, $authUserPassword);

            if (!matchCurrentPassword) {
                DB::rollBack();
                return response()->json(
                    [
                        'message' => lang::get('translation.current_password_doesnot_match_provided_password')
                    ], 400); 
            } else {
                $authUser->password = Hash::make($newPassword);
                $isPassowrdUpdated = $authUser->update();
                if ($isPassowrdUpdated) {
                    return response()->json([
                        'message' => lang::get('translation.password_updated')
                    ], 200);
                } else {
                    return response()->json([
                        'message' => lang::get('translation.password_not_updated')
                    ], 400);
                }
            }
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

            Log::error("Error | Controller: UserController | Function: updatePassword | Code: ".$code." | Message: ".$msg);

            return response()->json(lang::get('translation.error_500'), $code);
        }
    }
}
