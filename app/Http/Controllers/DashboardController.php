<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function root()
    {
        try{
            $user_company_id = Auth::user()->company_id;
            $messages_count = DB::table('messages')->where('company_id', $user_company_id )->count();
            $new_messages = DB::table('messages')->where('company_id', $user_company_id )->where('is_checked',0)->count();


            return view('index', compact('messages_count', 'new_messages'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: DashBoardController | Function: root | Code: ".$code." | Message: ".$msg);

            return abort(500);
        }

    }
}
