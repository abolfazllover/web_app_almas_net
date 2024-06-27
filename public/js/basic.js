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

function draw_rout_to_map(map,data){

    for (let k = 0; k < Object.keys(data.routes).length; k++) {

        for (let j = 0; j < Object.keys(data.routes[k].legs).length; j++) {

            for (let i = 0; i < Object.keys(data.routes[k].legs[j].steps).length; i++) {
                var step = data.routes[k].legs[j].steps[i];

                // decode Encoded polyline and draw on map
                L.Polyline.fromEncoded(step.polyline, {
                    color: "#250ECD",
                    weight: 12
                }).addTo(map);

                // add point in start of step
                L.circleMarker([step.start_location[1], step.start_location[0]], {
                    weight: 1,
                    color: "#FFFFFF",
                    radius: 5,
                    fill: true,
                    fillColor: "#9fbef9",
                    fillOpacity: 1.0
                }).addTo(map);
            }
        }
    }
}

async function neshan_api(address,fun){
    var data;
    await $.ajax({
        url : address ,
        headers: {
            'Api-Key': 'service.393611b6541247348119027bd24254d3'
        },
        dataType: 'json',
        success : function (e){
            fun(e)
        },
        error : function (e){
            error_alert('خطا در ارتباط با api نشان');
        }
    })
    return data;
}


