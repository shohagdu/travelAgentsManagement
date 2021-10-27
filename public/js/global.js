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

function AirlineTotalFare(){
    fare       = isNaN($("#fare").val()) ? 0 :      parseFloat($("#fare").val());
    tax_amount = isNaN($("#tax_amount").val()) ? 0 : parseFloat($("#tax_amount").val());
    total_fare =  parseFloat(fare+tax_amount);
    $("#total_fare").val(isNaN(total_fare) ? 0.00 : total_fare);

    commission = isNaN($("#commission").val()) ? 0 : parseFloat($("#commission").val());
    commissionAmount = (fare*commission/100);
    $("#commission_amount").val(isNaN(commissionAmount) ? 0.00 : commissionAmount);
    
    ait = isNaN($("#ait").val()) ? 0 : parseFloat($("#ait").val());
    aitAmount = (fare*ait/100);
    var ait_amount = $("#ait_amount").val(isNaN(aitAmount) ? 0.00 : aitAmount);

    add = isNaN($("#add").val()) ? 0 : parseFloat($("#add").val());

    var invoiceAmount = parseFloat((total_fare+aitAmount+add)-commissionAmount);

    $("#invoice_total").val(isNaN(invoiceAmount) ? 0.00 : invoiceAmount);

}