<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HtmlController extends Controller
{
    public  $dom;
    public function __construct()
    {
        $this->dom=new \DOMDocument();
        libxml_use_internal_errors(true);
    }

    function change_action_from($action){
        $forms= $this->dom->getElementsByTagName('form');
        foreach ($forms as $form){
            $inp_token=$this->dom->createElement("input");
            $inp_token->setAttribute('type','hidden');
            $inp_token->setAttribute('value',csrf_token());
            $inp_token->setAttribute('name','_token');
            $form->appendChild($inp_token);

            $form->setAttribute('action',$action);
        }
    }
    function remove_comments_from_html($html) {
        // استفاده از عبارت با قاعده برای پیدا کردن و حذف کامنت‌ها
        $html = preg_replace('/<!--.*?-->/s', '', $html);
        return $html;
    }

    function load_string($string_dom){
        $string_dom=$this->remove_comments_from_html($string_dom);
        $this->dom->loadHTML("<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>".$string_dom);

    }

    function analizor_select2_input(){
        $selects= $this->dom->getElementsByTagName('select');
        foreach ($selects as $select){
            $class=$select->getAttribute('class');
            $class=str_replace('erja','',$class);
            $class=str_replace('slc','',$class);

            $select->setAttribute('class',$class." select2");
        }
    }

    function remove_input_from_name_attr($name_attr){
        foreach ($this->dom->getElementsByTagName('input') as $elm){
            if ($elm->getAttribute('name')==$name_attr){
                $parent = $elm->parentNode;
                if ($parent) {
                    $parent->removeChild($elm);
                }
            }
        }
    }

    function remove_element($name_element){
        foreach ($this->dom->getElementsByTagName($name_element) as $elm){
            $parent = $elm->parentNode;
            if ($parent) {
                $parent->removeChild($elm);
            }
        }
    }

    function remove_input_attr($name_attr){
        foreach ($this->dom->getElementsByTagName('input') as $elm){
            $elm->setAttribute($name_attr,'');
        }
    }

    function newTicket(){
        $string_dom=(new ApiController())->get_page('newticket')['result'];
        $this->load_string($string_dom);

        $this->change_action_from(route('sub_ticket'));
        $this->analizor_select2_input();
        return $this->dom->saveHTML();
    }

    function new_repjop($edit){
        $param=null;
        if ($edit!=null){
            $param[]=['key'=>'edit','val'=>$edit];
        }
        $string_dom=(new ApiController())->get_page('newlistrepjop',$param)['result'];
        $this->load_string($string_dom);
        $this->analizor_select2_input();
        $this->remove_input_from_name_attr('malek');
        $this->change_action_from(route('sub_repjop'));
        return $this->dom->saveHTML();
    }

    function newreqvacations(){
        $string_dom=(new ApiController())->get_page('newreqvacations')['result'];
        $this->load_string($string_dom);
        $this->change_action_from(route('sub_new_vacation',['edit'=>'']));

        return $this->dom->saveHTML();
    }

    function show_reqvacation($id){
        $string_dom=(new ApiController())->get_page('seereqvacation',[
            ['key'=>'seereqvacation','val'=>$id]
        ])['result'];
        $this->load_string($string_dom);
        $this->remove_element('img');
        return $this->dom->saveHTML();
    }
}
