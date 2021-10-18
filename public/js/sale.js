var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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
function filghtCaculation(row_id){

    var fare        = parseFloat($('#fare_'+row_id).val());
    var tax         = parseFloat($('#tax_'+row_id).val());
    var commission  = parseFloat($('#commission_'+row_id).val());
    var ait         = parseFloat($('#ait_'+row_id).val());
    var add         = parseFloat($('#add_'+row_id).val());

    parseFloat($('#totalFare_'+row_id).val(fare+tax));

    var NetTotal = parseFloat((fare+tax+ait+add)- commission);

     parseFloat($('#amount_'+row_id).val(NetTotal));

    totalSummation();
   
}
// summation
function totalSummation(){

    var sum= 0;
    $(".Amount").each(function(){
        sum += +$(this).val();

    });

    parseFloat($('#NetTotal').val(sum));   
}




 // addNewFlight

function addNewFlight(){
    var total_element = $(".element1").length;

 var lastid = $(".element1:last").attr("id");
 var split_id = lastid.split("_");
 var nextindex = Number(split_id[1]) + 1;

 //console.log(nextindex);
 airline_info_all();

 var max = 20;

 if(total_element < max ){
  $(".element1:last").after("<tr class='element1' id='flightAreaDiv_"+ nextindex +"'></tr>");

  $("#flightAreaDiv_" + nextindex).append('<td class="actionTh"> <button type="button" onclick="removeNewFlight('+nextindex+');" class="btn btn-sm btn-danger FlightPlusBtn"><i class="mdi mdi-minus-box-outline"></i> </button></td> <td class="airlineTh"> <select class="form-control FlightInfo" name="flight_id" id="flight_id_'+nextindex+'"><option value=""> Select Flight</option></select></td><td class="fareTh"><input name="fare" id="fare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control" placeholder="0.00"/></td> <td class="TaxTh"><input name="tax" id="tax_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control" placeholder="0.00"/></td><td class="totalFareTd"><input name="total_fare[]" id="totalFare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control" placeholder="0.00"/></td><td class="commissionTh"><input name="commission" id="commission_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')"class="form-control" placeholder="0.00"/></td><td class="aitTh"><input name="ait" id="ait_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control" placeholder="0.00"/></td><td class="addTd"><input name="add" id="add_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control" placeholder="0.00"/></td><td class="amountTh"><input name="amount" id="amount_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="form-control Amount" placeholder="0.00"/></td>');

 }
}
function removeNewFlight(id){
	var deleteindex = id;
	$("#flightAreaDiv_" + deleteindex).remove();
}


$(document).off('change').on('change', '.FlightInfo', function(e) {

    var Flightid = this.id;
    var lastChar = Flightid[Flightid.length -1];

      let loc = $('meta[name=path]').attr("content");
      var filght_value_id = this.value;

          $.ajax({
                type:'POST',
                url:loc+'/get_flight_setup_info',
                data: {filght_value_id: filght_value_id},
                 success: function (response) {

                    var fare       = parseFloat(response.data.flight_data.fare);
                    var tax        = parseFloat(response.data.organization_data.tax_amount);
                    var commission = parseFloat(response.data.flight_data.commission);
                    var ait        = parseFloat(response.data.organization_data.ait);
                    var add        = parseFloat(response.data.flight_data.add);
                    var total_fare = parseFloat(fare+tax);
                    var total_amount = parseFloat((fare+tax+ait+add)-commission);

                   $('#fare_'+lastChar).val(fare);
                   $('#tax_'+lastChar).val(tax);
                   $('#totalFare_'+lastChar).val(total_fare);
                   $('#commission_'+lastChar).val(commission);
                   $('#ait_'+lastChar).val(ait);
                   $('#add_'+lastChar).val(add);
                   $('#amount_'+lastChar).val(total_amount);

                   totalSummation()

               // console.log(response.data.flight_data.airline_title);

             }
             });
 });