
<form enctype="multipart/form-data" class="row w-100 m-auto mt-3" method="post" action="{{route('sub_answer_ticket')}}">
    @csrf
    <input type="hidden" name="code" value="{{$code}}">
    <div class="col-6">
        <label>وضعیت :</label>
        <select name="status" required class="form-select">
            <option>درحال پیگیری</option>
            <option>درحال تامین کالا</option>
            <option>در لیست مراجعات کارشناس</option>
            <option>بسته شده</option>
        </select>
    </div>

    <div class="col-6">
        <label>ارجاع :</label>
        <select name="erja" required class="form-control select2">
            @foreach($basic_info['personels'] as $item)
            <option value="{{$item['username']}}">{{$item['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mt-2">
        <label>توضیحات ارجاع :</label>
        <textarea required name="dicerja" class="form-control"></textarea>
    </div>

    <div class="col-12 mt-2">
        <label>توضیحات مشترک :</label>
        <textarea name="dic" class="form-control"></textarea>
    </div>

    <div class="col-12 mt-2">
        <label>فایل ضمیمه :</label>
        <input name="file" class="form-control" type="file">
    </div>

    <div class="col-12 mt-3">
        <button class="btn p-2 rounded-2 btn-success d-block w-100">ثبت و ارجا</button>
    </div>
</form>
