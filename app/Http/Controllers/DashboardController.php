<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function root(){
        try{

            $user_company_id = Auth::user()->company_id;

            // return $user_company_id;

            $messagesCount = DB::table('messages')->where('company_id', $user_company_id )->count();
            $newMessages = DB::table('messages')->where('company_id', $user_company_id )->where('is_checked',0)->count();


            // $messagesCount = $messages->total_messages;
            // $newMessages = $messages->new_messages;


            return view('index', compact('messagesCount', 'newMessages'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            return $msg;

            Log::error("Error | Controller: DashBoardController | Function: root | Code: ".$code." | Message: ".$msg);

            return abort(500);
        }

    }
}
