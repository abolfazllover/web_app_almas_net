@include("components.user_info_section")
@php
$q="requserlog where code='$code' order by id DESC";
$data=(new \App\Http\Controllers\ApiController())->get_log_ticket($code);
$data=$data['result'];
@endphp

<style>
    .cardz{
        padding: 10px;
        margin: 10px 5px;
        background: #f0f0f0;
        box-shadow: 0 0 7px 1px #c9c9c9;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>

@foreach($data as $item)
<div class="cardz">
    <span class="fa fa-user"></span>
    <span>{{$item['user']}}</span>
    <p class="border-top pt-1">
      <span style="font-size: 0.7rem;color: #4f4f4f"> توضیحات ارجاع :</span>
        {{$item['dicerja']}}
    </p>
    <p class="">
        <span style="font-size: 0.7rem;color: #4f4f4f"> توضیحات مشترک :</span>
        {{$item['dic']}}
    </p>
    <div class="d-flex justify-content-between align-items-center">
        <h6 style="font-size: 0.7rem;color: #3B94DC">
            ارجاع شده به :
            {{$item['erja']}}
        </h6>
        <h6 style="font-size: 0.6rem;color: #737373">
            تاریخ :
            {{\Morilog\Jalali\Jalalian::forge($item['date'])}}
        </h6>
    </div>
    @if($item['file']!='')
    <a href="{{basic_api_url()}}/user/req-file/{{$item['file']}}" download="" class="btn btn-sm btn-primary" style="font-size: 0.7rem">دانلود ضمیمه</a>
    @endif
</div>
@endforeach
