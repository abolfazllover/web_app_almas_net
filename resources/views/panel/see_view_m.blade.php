@if(request('id')==null)
    @php
    $i=1;
        $data=(new \App\Http\Controllers\EmkController())->get_see_view_m();
    @endphp
    @if($data!=null)

        <h6 class="border-bottom pb-2 my-2 text-muted">در انتظار ثبت اطلاعات</h6>
        @foreach($data as $emk)
            <div class="row w-100 m-auto my-1 py-2 rounded-2 border shadow-sm">
                <div class="col-2 d-flex align-items-center">
                    <span class="border-end" style="min-width: 40px;padding: 5px">{{$i++}}</span>
                </div>
                <div class="col-8">
                    <h4 style="font-size: 0.8rem">{{compile_name_users($emk)}}</h4>
                    <p class="m-0 text-primary">{{$emk['ostan']}}</p>
                </div>

                <div class="col-2 ">
                    <a href="?id={{$emk['id']}}" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>

            </div>
        @endforeach
    @else
        <p class="alert alert-info p-1 rounded-2">درحال حاضر رکوردی وجود ندارد</p>
    @endif

@else
    @php
        $emk_data=(new \App\Http\Controllers\EmkController())->get_see_view_m(request('id'));
        $emk_data=$emk_data[0];
    @endphp
    <div class="col-12 pe-1 ps-1">
        @include("components.user_info_section")
        <a href="{{route('page',['toolz_emk_map','lat'=>$emk_data['lat'],'lon'=>$emk_data['lon']])}}" class="d-block my-2 py-2 btn border text-muted">
            <i class="fa fa-tools"></i>
            ابزار امکان سنجی
        </a>

        <a href="{{route('page',['routing_map','lat'=>$emk_data['lat'],'lon'=>$emk_data['lon']])}}" class="d-block my-2 py-2 btn border text-muted">
            <i class="fa fa-map"></i>
            مسیریابی
        </a>

        <h6 class="border-bottom pb-2 my-2 text-muted mt-4">ثبت اطلاعات</h6>
        <form action="{{route('sub_view_m')}}" method="post">
            @csrf
            <input type="hidden" name="nzrviwe" value="{{request('id')}}">
            <div class="d-flex justify-content-center">
                <div>
                    <input name="yes" id="yes" type="radio">
                    <label for="yes">بازدید شد</label>
                </div>
                <div class="ms-2 me-2">
                    <input name="no" id="no" type="radio">
                    <label for="no">بازدید نشد</label>
                </div>
            </div>

            {{-- بدنه بازدید شد --}}
            <div id="for_yes" style="display: none">
                <label>وضعیت :</label>
                <select name="status" class="form-select">
                    <option>امکان سنجی موفق</option>
                    <option>امکان سنجی ناموفق</option>
                </select>


                <label class="mt-4">کارشناس بازدید کننده :</label>
                <select name="viwem_user" class="w-100 form-select select2">
                    @foreach($basic_info['personels'] as $personel)
                        <option>{{ $personel['username']}}</option>
                    @endforeach
                </select>
            </div>
            {{--اتمام بدنه--}}

            {{-- بدنه بازدید نشد --}}
            <div id="for_no" style="display: none">
                <label class="mt-2">دلیل :</label>
                <select name="catviwe" class="form-select">
                    <option>تاخیر در امکان سنجی</option>
                    <option>کنسل شدن درخواست</option>
                    <option>نیاز در آینده</option>
                </select>
            </div>
            {{--اتمام بدنه--}}


            <label class="mt-2">توضیحات :</label>
            <textarea name="dic" class="form-control"></textarea>

            <button id="btn" disabled class="btn btn-success w-100 mb-3 mt-2 d-block">ثبت اطلاعات</button>
        </form>
    </div>

    <script>
        $('#yes').click(function (){
            $('#for_yes').fadeIn()
            $('#for_no').fadeOut()
            $('#no').prop('checked',false)
            $('#btn').prop('disabled',false)
        })

        $('#no').click(function (){
            $('#for_no').fadeIn()
            $('#for_yes').fadeOut()
            $('#yes').prop('checked',false)
            $('#btn').prop('disabled',false)
        });


    </script>
@endif

<script>
    active_back_icon()
</script>
