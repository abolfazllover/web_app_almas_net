<?php

namespace App\Http\Controllers;

use App\Models\TrafficModel;
use Illuminate\Http\Request;
use GuzzleHttp;
use Morilog\Jalali\Jalalian;

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

        return $result;

    }

    function check_user(): bool
    {
        if (getCookie('token')==null){
            return false;
        }else{

            $ris=$this->send_req('check_token',['token'=>getCookie('token')]);
            $ris=json_decode($ris,true);



            if (isset($ris['result']) && $ris['result']=='valid'){
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

    function sub_location(Request $data){
        $token=getCookie('token');
        $data['token']=$token;

        $result=$this->send_req('sub_traffic',$data->all());
        return $result;
    }


    function sub_playload(Request $request){
        $code=$request['code'];
        $user=$request['user'];
        $code=Jalalian::now()->format('Y/m/d')."-".$code."-".$user;
        $request['token']=getCookie('token');
        $request['code']=$code;


        $playload=['lat'=>$request['lat'],'lon'=>$request['lon'],'date'=>now()];

        $last_model=TrafficModel::where('code',$code)->first();
        if ($last_model==null){
            $request['playload']=json_encode($playload);
            TrafficModel::create($request->all());
        }else{
            $p_last=json_decode($last_model['playload'],true);
            $p_last[]=$playload;
            $request['playload']=json_encode($p_last);
            $last_model->update($request->all());
        }
        return success_json('');
    }


    function get_basic_data(){
        $result=$this->send_req('get_basic_data',['token'=>getCookie('token')]);
        return json_decode($result,true);
    }


    function get_data($db_name){
        $result=$this->send_req('gat_data',['token'=>getCookie('token'),'db_name'=>$db_name]);
        return json_decode($result,true);
    }

    function sub_view_m(Request $request){

        $request['token']=getCookie('token');
        $result=$this->send_req('nzrviwe',$request->all());
        return redirect()->route('page','see_view_m')->with('success','با موفقیت اطلاعات شما ثبت شد');
    }


    function get_namem_tci(){
        $result=$this->send_req('get_namem_tci',['token'=>getCookie('token')]);
        return json_decode($result,true);
    }

    function get_active_users_namem(Request $request){
        $result=$this->send_req('get_active_users_namem',['token'=>getCookie('token'),'namem'=>$request['namem']]);
        return json_decode($result,true);
    }

    function get_code_sub_traffic(){
        $result=$this->send_req('get_code_traffic',['token'=>getCookie('token')]);
        return json_decode($result,true);
    }



}
