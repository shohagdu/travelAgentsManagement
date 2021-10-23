var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function saleCategory(categoryId){
    
    if(categoryId == 1){
        $("#headingText").text("Flight Information!");
        $('.FlightSaleTable').show();
        $('.HotelSaleTable').hide();
    }else if(categoryId == 2){
        $("#headingText").text("Hotel Information!");
        $('.HotelSaleTable').show();
        $('.FlightSaleTable').hide();
    }
}
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
function TotalEmptycheck(row_id){

    var fare        = parseFloat($('#fare_'+row_id).val());
    var tax         = parseFloat($('#tax_'+row_id).val());
    var commission  = parseFloat($('#commission_'+row_id).val());
    var ait         = parseFloat($('#ait_'+row_id).val());
    var add         = parseFloat($('#add_'+row_id).val());

    var NetTotalEmpty = (fare+tax+ait+add)- commission;

    return NetTotalEmpty;
   
}
// summation
function totalSummation(){

    var sum= 0;
    $(".Amount").each(function(){
        sum += +$(this).val();

    });

    $('#NetTotal').val(sum.toFixed(2));   

    var discount = $('#Discount').val();

    var InvoiceAmount = (sum-discount);   
   // console.log(InvoiceAmount);

    $('#invoice_amount').val(InvoiceAmount.toFixed(2));
}

function DiscountSale(){

    var NetTotalAmount = $('#NetTotal').val();
    var discount       = $('#Discount').val();

    var TotalInvAmount = (NetTotalAmount-discount);

    $('#invoice_amount').val(TotalInvAmount.toFixed(2));
}

 // addNewFlight

function addNewFlight(){
 var total_element = $(".element1").length;

 var lastid = $(".element1:last").attr("id");
 var split_id = lastid.split("_");
 var nextindex = Number(split_id[1]) + 1;


 if(TotalEmptycheck(nextindex-1) > 0){
    
    airline_info_all();

    var max = 20;

    if(total_element < max ){
    $(".element1:last").after("<tr class='element1' id='flightAreaDiv_"+ nextindex +"'></tr>");

    $("#flightAreaDiv_" + nextindex).append('<td class="actionTh"> <button type="button" onclick="removeNewFlight('+nextindex+');" class="btn btn-xs btn-danger FlightPlusBtn"><i class="mdi mdi-minus-box-outline"></i> </button></td> <td class=""> <select class="FlightTd FlightInfo" name="flight_id[]" id="flight_id_'+nextindex+'"><option value=""> Select Flight</option></select></td><td class=""><input name="fare[]" id="fare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="fareTd" placeholder="0.00"/></td> <td class=""><input name="tax[]" id="tax_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="taxTd" placeholder="0.00"/></td><td class=""><input name="total_fare[]" id="totalFare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="totalFareTd" placeholder="0.00"/></td><td class=""><input name="commission[]" id="commission_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="commissionTd" placeholder="0.00"/></td><td class=""><input name="ait[]" id="ait_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="aitTd" placeholder="0.00"/></td><td class=""><input name="add[]" id="add_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="AddTd" placeholder="0.00"/></td><td class="amountTh"><input name="amount[]" id="amount_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="amountTd Amount" placeholder="0.00" readonly/></td>');

    }

 }else{
     alert("Please Enter Amount");
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
                    var total_amount = parseFloat((fare+tax+ait+add)-commission).toFixed(2);

                   $('#fare_'+lastChar).val(fare);
                   $('#tax_'+lastChar).val(tax);
                   $('#totalFare_'+lastChar).val(total_fare);
                   $('#commission_'+lastChar).val(commission);
                   $('#ait_'+lastChar).val(ait);
                   $('#add_'+lastChar).val(add);
                   $('#amount_'+lastChar).val(total_amount);

                   totalSummation()

             }
             });
 });


 
$(document).ready(function(){
    get_sale_info_list();
}); 

// sale list
var token_table;

function get_sale_info_list() {
    let target = $("#asset").val();

    token_table = $('#sale_list_table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        serverSide: true,
        processing: true,
        "paging": true,
        "searching": { "regex": true },
        "pageLength": 10,
        
        ajax:{
            dataType: "JSON",
            type: "post",
            url: target + "get_sale_list_data",
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
            	title: "Agent Name",
                data: "agent_name"
            },
            {
                title: "Sale Category",
                data: null,
                render: function (data) {
                    if(data.sale_category_id==1){
                        return 'Flights';
                    }
                    else if(data.sale_category_id==2){
                        return 'Hotels';
                    }
                    else if(data.sale_category_id==4){
                        return 'Activities';
                    }
                    else if(data.sale_category_id==5){
                        return 'Holidays';
                    }
                    else if(data.sale_category_id==6){
                        return 'Visa';
                    }
                    else if(data.sale_category_id==7){
                        return 'Others';
                    }
                }
            },
            {
                title: "Amount",
                data: "amount"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<a href="" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>Edit </a> <a onclick="return confirm(\'Are you sure you want to delete?\')" href="" class="btn btn-danger btn-sm text-white"><span class="mdi mdi-delete-circle"></span>  Delete </a>';
                }
            },
        ],
    });
}

// search sale report
function search_sale_reports ()
{
    sale_category_id  = $("#sale_category_id").val();
    agent_id          = $("#agent_id").val();

    $("#sale_list_table").dataTable().fnSettings().ajax.data.sale_category_id = sale_category_id;
    $("#sale_list_table").dataTable().fnSettings().ajax.data.agent_id    = agent_id;

    token_table.ajax.reload();
}