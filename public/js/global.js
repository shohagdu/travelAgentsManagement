var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("#zero_config").DataTable();
$(".select2").select2();

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

  $("#flightAreaDiv_" + nextindex).append('<td class="actionTh"> <button type="button" onclick="removeNewFlight('+nextindex+');" class="btn btn-sm btn-danger FlightPlusBtn"><i class="mdi mdi-minus-box-outline"></i> </button></td> <td class="airlineTh"> <select class="form-control FlightInfo" name="flight_id" id="flight_id_'+nextindex+'"><option value=""> Select Flight</option></select></td><td class="fareTh"><input name="fare" id="fare_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td> <td class="TaxTh"><input name="tax" id="tax_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td><td class="totalFareTd"><input name="tax" id="tax_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td><td class="commissionTh"><input name="commission" id="commission_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td><td class="aitTh"><input name="ait" id="ait_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td><td class="addTd"><input name="add" id="add_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td><td class="amountTh"><input name="amount" id="amount_'+nextindex+'" type="text" class="form-control" placeholder="0.00"/></td>');

 }
}
function removeNewFlight(id){
	var deleteindex = id;
	$("#flightAreaDiv_" + deleteindex).remove();
}
