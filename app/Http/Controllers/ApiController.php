<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;

class ApiController extends Controller
{
    function send_req($method,$data){
        $ris=new GuzzleHttp\Client();
        $r=$ris->request('post',api_url()."/?$method",[
            'form_params' => $data
        ]);
        return $r->getBody()->getContents();
    }

    function login(Request $request){
        $result=$this->send_req('login',$request->all());
        $data=json_decode($result,true);
        if ($data['status']=='success'){
            saveCookie('token',$data['result']['token'],(12*60));
        }
        return  $result;
    }

    function check_user(): bool
    {
        if (getCookie('token')==null){
            return false;
        }else{

            $ris=$this->send_req('check_token',['token'=>getCookie('token')]);
            $ris=json_decode($ris,true);

            if ($ris['result']=='valid'){
                return  true;
            }else{
                return  false;
            }
        }
    }

    function user_info(){
        $ris=$this->send_req('info_user',['token'=>getCookie('token')]);
        return json_decode($ris,true)['result'] ?? null;
    }
}
