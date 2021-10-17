const { Button } = require("bootstrap");

var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("#zero_config").DataTable();
// $(".select2").select2();

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

// agent
// Token list
var token_table;
function get_agent_list() {
    let target = $("#asset").val();
    token_table = $('#agent_list_table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        serverSide: true,
        processing: true,
        ajax:{
            dataType: "JSON",
            type: "post",
            url: target + "/get_agent_list_info",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return token_table.page.info().start + token_table.column(0).nodes().length;
                }           
            },
            {
            	title: "Name",
                data: "name"
            },
            {
            	title: "Mobil",
                data: "mobile"
            },
            {
            	title: "Email",
                data: "email"
            },
            {
            	title: "Country",
                data: "country_name"
            },
            {
            	title: "City",
                data: "city_name"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                     return  "<a  ><p class='btn btn-sm btn-info'> <i class='fa fa-pencil' aria-hidden='true'> Edit </i> </p> </a> <a href='#" + data.id + "' ><p class='btn btn-sm btn-danger'> <i class='fa fa-trash' aria-hidden='true'></i></p> </a>";
                }
            },
        ],
    });
}

function search_agent_list()
{
    country = $("#country").val();
    city    = $("#city").val();
    mobile  = $("#mobile").val();

    $("#agent_list_table").dataTable().fnSettings().ajax.data.country  = country;
    $("#agent_list_table").dataTable().fnSettings().ajax.data.city     = city;
    $("#agent_list_table").dataTable().fnSettings().ajax.data.mobile   = mobile;

    token_table.ajax.reload();
  }