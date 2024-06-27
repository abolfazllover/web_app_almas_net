<?php

use Illuminate\Support\Facades\Cookie;

function saveCookie($name, $value, $minutes = 60) {
    $cookie = Cookie::make($name, $value, $minutes);
    Cookie::queue($cookie);
}

function getCookie($name) {
    return Cookie::get($name);
}

function api_url(): string
{
//    return "https://almas-net.com/crm/api";
    return  "http://localhost/almas/crm/api";
}


function success_json($data){
    return response()->json([
        'status'=>'success',
        'result'=>$data
    ]);
}

function error_json($msg){
    return response()->json([
        'status'=>'error',
        'message'=>$msg
    ]);
}

function compile_name_users($emk_data){
    if ($emk_data['type']=='حقیقی'){
        return $emk_data['name']." ".$emk_data['family'];
    }
    return $emk_data['namesh'];
}

