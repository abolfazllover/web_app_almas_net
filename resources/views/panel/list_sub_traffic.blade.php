<div class="col-12 ps-1 pe-1">
    <a href="{{route('page',['sub_traffic','lat'=>35.699756,'lon'=>51.338076])}}" class="d-block w-100 my-2 btn border btn-primary">
        <i class="fa fa-plus"></i>
        ثبت تردد جدید
    </a>

    <div class="mt-4">
        <h6 class="border-bottom pb-2 d-flex justify-content-between align-items-center">
            لیست تردد های ثبت شده
            <span style="background: #ccc;font-size: 0.8rem" class="rounded-2 p-1">
                امروز -
                {{\Morilog\Jalali\Jalalian::now()->format('Y/m/d')}}
            </span>
        </h6>
        <table class="table table-bordered table-striped text-center">
            <tr>
               <td>مبدا</td>
               <td>مقصد</td>
            </tr>
        </table>
    </div>
</div>

<script>
    active_back_icon();
</script>