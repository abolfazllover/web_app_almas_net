<div class="col-12 ps-1 pe-1">
    <a href="{{route('page','newreqvacations')}}" class="d-block w-100 my-2 btn border btn-primary">
        <i class="fa fa-plus"></i>
        ثبت درخواست جدید
    </a>
</div>

<h6 class="border-bottom pb-1 my-2 mt-4">لیست درخواست ها</h6>
@foreach((new \App\Http\Controllers\ApiController())->my_list_req_vacations()['result'] as $item)
<a href="{{route('page',['show_reqvacation','id'=>$item['id']])}}" class="item my-2 border p-3 rounded-2 text-center position-relative" style="display: block">
    <h4 class="mt-2" style="font-size: 1rem">مرخصی
    {{$item['timestring']}}
    </h4>
    <div class="d-flex justify-content-center align-items-center">
        <h6 class="ms-1 me-1" style="font-size: 0.7rem;color: #575757">
          {{$item['timenumber']}} --
            وضعیت :
            {{$item['status']}}
        </h6>
    </div>
    <span>{{$item['typereq']}}
    - تاریخ شروع :
        {{$item['dates']}}
    </span>
    <span style="font-size: 0.6rem;position: absolute;left: 5px;top: 5px;color: #4f4f4f">{{\Morilog\Jalali\Jalalian::forge($item['date'])->format('Y/m/d')}}</span>
</a>
@endforeach

<script>
    active_back_icon();
</script>
