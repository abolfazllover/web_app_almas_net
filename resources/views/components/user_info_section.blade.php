@if($emk_data==null)
    <p class="alert alert-warning p-2">اطلاعات مشترک یافت نشد!</p>
@else

<style>
    #l1{
        padding: 0;
    }
    #l1 li{
        border-bottom: 1px solid #ccc;
    }
</style>


<h6 class="border-bottom pb-2 my-2 text-muted">اطلاعات مشترک</h6>



<ul id="l1">
    <li>
        نوع شخصیت :
        {{$emk_data['type']}}
    </li>
    <li>
        نام مدیر عامل  :
        {{$emk_data['name']}}
    </li>
    <li>
        نام خانوادگی مدیر عامل :
        {{$emk_data['family']}}
    </li>
    <li>
        شماره تماس مدیر عامل :
        {{$emk_data['phone']}}
    </li>

    <li>
        نام نماینده فنی  :
        {{$emk_data['nameF']}}
    </li>
    <li>
        نام خانوادگی نماینده فنی :
        {{$emk_data['familyF']}}
    </li>
    <li>
        شماره تماس نماینده فنی :
        {{$emk_data['phoneF']}}
    </li>

    <li>
        سرویس انتخابی :
        {{$emk_data['service']}}
    </li>
    <li>
        ارتفاع اعلامی از سمت مشترک :
        {{$emk_data['maxer']}}
    </li>
    <li>
        طول جغرافیایی :
        {{$emk_data['lat']}}
    </li>
    <li>
        عرض جغرافیایی :
        {{$emk_data['lon']}}
    </li>
    <li>
        آدرس :
        {{$emk_data['addres']}}
    </li>
</ul>
@endif
