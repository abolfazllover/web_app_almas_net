<?php

namespace App\Http\Controllers;

use App\Models\TrafficModel;
use Illuminate\Http\Request;
use GuzzleHttp;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Morilog\Jalali\Jalalian;

class ApiController extends Controller
{

    function send_req($method, $data,UploadedFile $file=null) {
        $client = new GuzzleHttp\Client();


        // برای تهیه multipart برای ارسال
        $multipart = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    $multipart[] = [
                        'name' => $key . '[]',
                        'contents' => $subValue
                    ];
                }
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value
                ];
            }
        }

        // اضافه کردن فایل به multipart
        if ($file!==null){
            $multipart[] = [
                'name' => 'file', // نام فیلدی که فایل را با آن ارسال می‌کنید
                'contents' => $file->getContent(), // باز کردن فایل برای ارسال
                'filename' => $file->getClientOriginalName() // نام فایل
            ];
        }


        // ارسال درخواست به سرور
        try {
            $response = $client->request('POST', api_url() . "/?$method", [
                'multipart' => $multipart
            ]);

            // بازگرداندن محتوای بدنه پاسخ
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            // مدیریت خطا
            return 'Error: ' . $e->getMessage();
        }
    }


    function login(Request $request){
        $result=$this->send_req('login',$request->all());
        $data=json_decode($result,true);
        if ($data['status']=='success'){
            saveCookie('token',$data['result']['token'],30*(24*60));
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

    function get_my_erja_ticket(){
        $token=getCookie('token');
        $data=[];
        $data['token']=$token;
        $result=$this->send_req('my_erja_ticket',$data);

        return json_decode($result,true);
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

    function get_log_ticket($code){
        $result=$this->send_req('get_log_ticket',['token'=>getCookie('token'),'code'=>$code]);
        return json_decode($result,true);
    }

    function sub_answer_ticket(Request $request){
        $request['token']=getCookie('token');
        if ($request->hasFile('file')){
            $file=$request->file('file');
        }else{
            $file=null;
        }

        $result=$this->send_req('addlogrequser',$request->all(),$file);
        return redirect()->route('page','my_ticket')->with('success','با موفقیت اطلاعات شما ثبت شد');
    }

    function get_page($page_name,$param=null){
        $request=[];
        $request['page_name']=$page_name;
        $request['token']=getCookie('token');

        $addres='get_page';
        if ($param!=null){
            foreach ($param as $item){
                $addres.="&".$item['key'].'='.$item['val'];
            }
        }

        $result=$this->send_req($addres,$request);
        return json_decode($result,true);
    }

    function sub_ticket(Request $request){
        $request['token']=getCookie('token');
        if ($request->hasFile('file')){
            $file=$request->file('file');
        }else{
            $file=null;
        }
        $result=$this->send_req('subticket',$request->all(),$file);
        return redirect()->route('page','my_ticket')->with('success','با موفقیت تیکت ایجاد شد');
    }

    function sub_repjop(Request $request){
        unset( $request['_token']);
        $request['token']=getCookie('token');
        $result=$this->send_req('newlistrepjop',$request->all());
        return redirect()->route('page','list_repjop')->with('success','گزارش کار شما با موفقیت ثبت شد');
    }

    function get_list_repjop(){
        $request=[];
        $request['token']=getCookie('token');
        $result=$this->send_req('get_list_repjop',$request);
        return json_decode($result,true);
    }

    function sub_new_vacation(Request $request){
        $request['token']=getCookie('token');
        unset($request['_token']);
        $result=$this->send_req('newreqvacation',$request->all());
        return redirect()->route('page','list_reqvations')->with('success','درخواست مرخصی شما با موفقیت ثبت شد');
    }

    function my_list_req_vacations(){
        $data=[
            'token'=>getCookie('token')
        ];
        $result=$this->send_req('my_list_req_vacations',$data);
        return json_decode($result,true);
    }

}
