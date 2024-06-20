<!doctype html>
<html lang="fa" class="w-100 h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>وب اپلیکیشن الماس نت</title>
    @include('meta')
</head>
<body class="w-100 h-100 d-flex justify-content-center align-items-center">
<div class="col-md-3 col-11 border p-2 shadow-sm">
    <section>
        <div class="text-center">
            <img style="max-width: 200px;margin: auto" src="https://almas-net.com/img/logo.png" alt="logo">
        </div>
        @csrf
        <div>
            <label>نام کاربری :</label>
            <input name="username" id="username" class="form-control">
        </div>
        <div>
            <label>کلمه عبور :</label>
            <input id="password" name="password" class="form-control">
        </div>
        <div>
            <button onclick="login($(this))" class="btn btn-primary w-100 d-block my-2 rounded-2">ورود</button>
        </div>
    </section>
</div>
</body>
@include('config')

<script>
   function login(d){
       var username=$('#username').val();
       var password=$('#password').val();

       if(username=='' || password==''){
           error_alert('نام کاربری و رمز عبور نباید خالی باشد')
       }else {
           d.addClass('disabled')
           ajax_sender("{{route('api_login')}}",{
               'username' : username,
               'password' : password,
           },'post',function (e) {
              window.location="{{route('panel')}}";
           })
       }
       d.removeClass('disabled')
   }
</script>
</html>
