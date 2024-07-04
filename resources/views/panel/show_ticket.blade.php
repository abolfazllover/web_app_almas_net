@php
$code=request('code');

$emk_data=(new \App\Http\Controllers\EmkController())->get_emk_rel_ticket($code);
@endphp



@php $emk_data=$emk_data[0] ?? null @endphp
@include('components.ticket_log')
@include('components.ticket_form')


<script>
    active_back_icon();
</script>
