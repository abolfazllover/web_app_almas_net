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
}
