<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

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
                'email' => ['required', 'string', 'email'],
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
    
            $isUserUpdated = $authUser->save();
            if ($isUserUpdated) {
                DB::commit();
                return response()->json(
                    [
                    'message' => lang::get('translation.data_updated') 
                    ],
                     200); // Status code here
            } else {
                DB::rollBack();
                return response()->json(
                    [
                    'message' => lang::get('translation.data_not_updated') 
                    ],
                     400); // Status code here
            }
        }catch(Exception $e){
            DB::rollBack();
            
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: UserController | Function: updateUserProfile | Code: ".$code." | Message: ".$msg);

            return response()->json(['message' => lang::get('translation.error_500')], 500);
        }
        
    }
}
