var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// datatable
$( document ).ready(function() {
    $("#zero_config").DataTable();

 });

//  select2
$( document ).ready(function() {
   $(".select2").select2();

});

function airline_info_all(){
    $.ajax({
        url:url + "/airline_info_all",
        type: "POST",
        dataType: 'json',
        success:function(response){
            response.forEach(function(item) {
             $(".FlightInfo").append('<option  value=' + item.id + '>' + item.airline_title + '</option>');
         })
        }
    });
}


function getCity(country_id, target_id){

    $.ajax({
        url: url + "/get_city_info",
        type:"POST",
        dataType:"JSON",
        data:{
            country_id:country_id,
        },
        success:function(response){
            //console.log(response.data);

            if (response.status == 'success') {

                var list = "<option value=''>Select</option>";

                response.data.forEach(function(item){

                    list += "<option value='"+item.id+"'>"+item.name+"</option>";

                });

                $("#"+target_id).html(list);

            }else{

                $("#"+target_id).html("<option value=''>Not Found</option>");
            }

        }

     });
}

