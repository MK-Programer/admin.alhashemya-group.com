<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class DashBoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function root(){
        try{
            $authUser = Auth::user();
            $messages = DB::table('messages')
                            ->select(
                                DB::raw('COUNT(*) as total_messages'),
                                DB::raw('COUNT(CASE WHEN is_checked = 0 THEN 1 END) as new_messages')
                            )
                            ->where('company_id', $authUser->companyId)
                            ->first();
            $messagesCount = $messages->total_messages;
            $newMessages = $messages->new_messages;


            return view('index', compact('messagesCount', 'newMessages'));
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: DashBoardController | Function: root | Code: ".$code." | Message: ".$msg);

            return abort(500);
        }

    }
}
