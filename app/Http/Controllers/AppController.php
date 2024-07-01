<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Session;
class AppController extends Controller
{
    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function dataTableLang($locale){
        $path = public_path("build/js/lang/{$locale}/datatables.json");
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }
}
