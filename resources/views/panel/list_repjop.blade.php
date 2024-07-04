@php
$result=(new \App\Http\Controllers\ApiController())->get_list_repjop()['result'];
@endphp

<div class="col-12 ps-1 pe-1">
    <a href="{{route('page','new_repjop')}}" class="d-block w-100 my-2 btn border btn-primary">
        <i class="fa fa-plus"></i>
        ثبت گزارش کار
    </a>


    <h6 class="border-bottom pb-1 my-3">لیست گزارش کار</h6>
    @if($result==null)
    <div class="alert alert-info p-1 rounded-1">تا کنون گزارشی ثبت نکرده اید.</div>
    @else
    @foreach($result as $item)
    <div class="row m-auto my-1">
        <div class="col-12 border p-3 rounded-1">
            <h5 class="h6 d-flex justify-content-between align-items-center">
                <span>{{$item['title']}}</span>
                <span class="text-muted h6 small" style="font-size: 0.7rem">
                    {{\Morilog\Jalali\Jalalian::forge($item['date'])->format('Y/m/d - H:i')}}
                </span>
            </h5>
            <h6 class="m-0 text-muted h6 small d-flex justify-content-between align-items-center">
                <span>مرتبط با :
                    {{$item['rel']}}
                </span>
                <span class="h6">
                    <a href="{{route('page',['new_repjop','edit'=>$item['id']])}}" class="fa fa-edit text-primary"></a>
                </span>
            </h6>
        </div>
    </div>
    @endforeach
    @endif
</div>

<script>
    active_back_icon();
</script>
