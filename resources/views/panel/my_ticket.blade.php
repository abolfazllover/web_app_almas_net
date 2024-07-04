<a href="{{route('page',['new_ticket'])}}" class="d-block my-2 py-2 btn border text-muted">
    <i class="fa fa-plus"></i>
    افزودن تیکت
</a>

<h6 class="my-2 border-bottom pb-2">
    تیکت های من
</h6>
<input onkeyup="search()" id="src" style="font-size: 0.7rem" class="form-control" placeholder="جستوجو">
@foreach($basic_info['my_ticket'] as $item)
<a href="{{route('page',['show_ticket','code'=>$item['code']])}}" class="item my-2 border p-3 rounded-2 text-center position-relative" style="display: block">
    <h4 class="mt-2" style="font-size: 1rem">{{$item['title']}}</h4>
    <div class="d-flex justify-content-center align-items-center">
        <h6 class="ms-1 me-1" style="font-size: 0.7rem;color: #575757">ارجاع :
            {{$item['erja_fa']}}
        </h6>
        ---
        <h6 class="ms-1 me-1" style="font-size: 0.7rem;color: #575757">وضعیت  :
            {{$item['status']}}
        </h6>
    </div>
    <span style="font-size: 0.6rem;position: absolute;left: 5px;top: 5px;color: #4f4f4f">{{\Morilog\Jalali\Jalalian::forge($item['date'])->format('Y/m/d')}}</span>
</a>
@endforeach

<script>
    active_back_icon();

    function search(){
       var val=$('#src').val();
       $('.item').each(function (i,item) {

           if($(item).find('h4').text().search(val)>-1 || $(item).find('h6').text().search(val)>-1){
               $(item).show()
           }else {
               $(item).hide()
           }
       })
    }
</script>
