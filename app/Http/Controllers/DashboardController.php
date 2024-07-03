<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            return view('index');
        }catch(Exception $e){
            $code = $e->getCode();
            $msg = $e->getMessage();

            Log::error("Error | Controller: DashBoardController | Function: root | Code: ".$code." | Message: ".$msg);

            return abort(500);
        }
            
    }
}
