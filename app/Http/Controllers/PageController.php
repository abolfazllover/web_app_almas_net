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

    function log_out(){
      saveCookie('token','',1);
      return redirect()->route('login');
    }

    function page_panel($page='home'){
        $api=new ApiController();
        return view('panel.index')->with([
            'user'=>$api->user_info(),
            'page'=>$page,
            'basic_info'=>$api->get_basic_data()['result'],
        ]);
    }
}
