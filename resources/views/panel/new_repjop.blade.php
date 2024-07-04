{!! (new \App\Http\Controllers\HtmlController())->new_repjop(request('edit')) !!}

<script>
    $('form input[type=submit]').addClass('btn btn-success w-100 d-block');
    $('#slc').append("<option>***عملیات روزانه***</option>");

    active_back_icon();
</script>
