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
function AirlineSetupSummmation(){
    var total_fare         = isNaN($("#total_fare").val()) ? 0 : parseFloat($("#total_fare").val());
    var tax_amount         = isNaN($("#tax_amount").val()) ? 0 : parseFloat($("#tax_amount").val());
    var commission_amount  = isNaN($("#commission_amount").val()) ? 0 : parseFloat($("#commission_amount").val());
    var ait_amount         = isNaN($("#ait_amount").val()) ? 0 : parseFloat($("#ait_amount").val());
    var add                = isNaN($("#add").val()) ? 0 : parseFloat($("#add").val());

    var invoiceAmount = ((total_fare+tax_amount+ait_amount+add)-commission_amount);
    console.log(tax_amount);

    $(".invoice_total").val(isNaN(invoiceAmount) ? 0.00 : invoiceAmount.toFixed(2));
}

function AirlineTotalFare(){
    var fare       = isNaN($("#fare").val()) ? 0 :      parseFloat($("#fare").val());
    var tax_amount = isNaN($("#tax_amount").val()) ? 0 : parseFloat($("#tax_amount").val());
    var commission = isNaN($("#commission").val()) ? 0 : parseFloat($("#commission").val());
    var ait = isNaN($("#ait").val()) ? 0 : parseFloat($("#ait").val());
    var add = isNaN($("#add").val()) ? 0 : parseFloat($("#add").val());
    var total_fare =  (fare+tax_amount);
    var commissionAmount = (fare*commission/100);
    var aitAmount = (fare*ait/100);
   

    $("#total_fare").val(isNaN(total_fare) ? 0 : total_fare.toFixed(2));
    $("#commission_amount").val(isNaN(commissionAmount) ? 0 : commissionAmount.toFixed(2));
    $("#ait_amount").val(isNaN(aitAmount) ? 0 : aitAmount.toFixed(2));

   AirlineSetupSummmation();
}
