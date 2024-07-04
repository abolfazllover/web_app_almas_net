<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmkController extends Controller
{


    /*
     * دریافت رکورد بازدید میدانی
     *
     * */
    function get_see_view_m($id=null)
    {
        $q = "emk where status='در انتظار بازدید میدانی'";
        if ($id!=null){
         $q="emk where id='$id'";
        }
        $data = (new \App\Http\Controllers\ApiController())->get_data($q);
        $data = $data['result'];
        return $data;
    }

    function get_emk_data($code_emk){
        $q="emk where code='$code_emk'";
        $data = (new \App\Http\Controllers\ApiController())->get_data($q);
        $data = $data['result'];
        return $data;
    }

    function get_emk_rel_ticket($code_ticket){
        $q="requser where code='$code_ticket'";
        $data=(new ApiController())->get_data($q);
        if (isset($data['result'])){
            sleep(1);

            $rel=$data['result'][0]['rel'];

            if ($rel==''){
                $rel=$data['result'][0]['user'];
            }

            $q="ctm where username='$rel'";
            $data=(new ApiController())->get_data($q);

            if (isset($data['result']) && $data['result']!=null){

                $emk_code=$data['result'][0]['codemk'];
                return $this->get_emk_data($emk_code);
            }
        }
        return null;
    }
}
