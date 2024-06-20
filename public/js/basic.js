function isPersianAndSpecialChars(input) {
    const regex = /^[\u0600-\u06FF\s.!؟]+$/;
    return regex.test(input);
}


function isEqualToLength(input, length) {
    return input.length === length;
}
function isNumeric(input) {
    const regex = /^\d+$/;
    return regex.test(input);
}

function success_alert(msg,title='موفق'){
    $.notify({message : msg,title : title},{type : 'success'});
}

function error_alert(msg,title='خطا'){
    $.notify({message : msg,title : title});
}

function ajax_sender(url,data,method,success_fun){
    $.ajax({
       headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       url : url ,
       data : data,
       method : method,
       success : function (e){
           if (e.status==='success'){
               success_fun(e);
           }else {
               error_alert(e.message,'ناموفق')
           }
       },
       dataType : 'json',
       error : function (e){
           console.log(e)
           error_alert('خطا در ارتباط با سرور - با پشتیبان تماس بگیرید.','خطای سرور')
       }

    })
}


