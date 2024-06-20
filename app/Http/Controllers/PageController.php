<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    function page_login(){
        if ((new ApiController())->check_user()){
            return redirect()->route('panel');
        }else{
            return view('login.index');
        }
    }

    function page_panel($page='home'){

        return view('panel.index')->with([
            'user'=>(new ApiController())->user_info(),
            'page'=>$page
        ]);
    }
}
