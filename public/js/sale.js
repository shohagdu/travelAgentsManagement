var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function saleCategory(categoryId){
    // $(".showSalesFooterInfo").hide(200);
    if(categoryId == 1){
        $("#headingText").text("Flight Information!");
        $('.FlightSaleTable').show();
        $('.HotelSaleTable').hide();
        $('.HotelPlusBtn').hide();
        $('.FlightPlusBtn').show();
    }else if(categoryId == 2){
        $("#headingText").text("Hotel Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else if(categoryId == 3){
        $("#headingText").text("Transfers Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else if(categoryId == 4){
        $("#headingText").text("Activities Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else if(categoryId == 5){
        $("#headingText").text("Holidays Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else if(categoryId == 6){
        $("#headingText").text("Visa Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else if(categoryId == 7){
        $("#headingText").text("Others Information!");
        $('.HotelSaleTable').show();
        $('.HotelPlusBtn').show();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }else{
        $("#headingText").text("Information!");
        $('.HotelSaleTable').hide();
        $('.HotelPlusBtn').hide();
        $('.FlightPlusBtn').hide();
        $('.FlightSaleTable').hide();
    }
    $(".showSalesFooterInfo").show(300);
}
 function airline_info_all(){
    $.ajax({
        url:url + "/airline_info_all",
        type: "POST",
        dataType: 'json',
        success:function(response){
            response.forEach(function(item) {
             $(".FlightInfo").append('<option  value=' + item.id + '>' + item.airline_name + '</option>');
         })
        }
    });
}
function filghtCaculation(row_id){

    var fare        = isNaN($('#fare_'+row_id).val()) ? 0 : parseFloat($('#fare_'+row_id).val());
    var tax         = isNaN($('#tax_'+row_id).val()) ? 0 : parseFloat($('#tax_'+row_id).val());
    var commission  = isNaN($('#commission_'+row_id).val()) ? 0 : parseFloat($('#commission_'+row_id).val());
    var ait         = isNaN($('#ait_'+row_id).val()) ? 0 : parseFloat($('#ait_'+row_id).val());
    var add         = isNaN($('#add_'+row_id).val()) ? 0 : parseFloat($('#add_'+row_id).val());

    parseFloat($('#totalFare_'+row_id).val((fare+tax).toFixed(2)));

    var NetTotal = parseFloat((fare+tax+ait+add)- commission);

    $('#amount_'+row_id).val(isNaN(NetTotal) ? 0:  NetTotal.toFixed(2));
   // console.log(NetTotal);

    totalSummation();

}
function filghtCommissionAITCaculation(row_id){
    var fare        = isNaN($('#fare_'+row_id).val()) ? 0 : parseFloat($('#fare_'+row_id).val());
    var tax         = isNaN($('#tax_'+row_id).val()) ? 0 : parseFloat($('#tax_'+row_id).val());
    var commission  = isNaN($('#commission_'+row_id).val()) ? 0 : parseFloat($('#commission_'+row_id).val());
    var ait         = isNaN($('#ait_'+row_id).val()) ? 0 : parseFloat($('#ait_'+row_id).val());
    var add         = isNaN($('#add_'+row_id).val()) ? 0 : parseFloat($('#add_'+row_id).val());
    var NetTotalAmount = parseFloat((fare+tax+ait+add)- commission);
    parseFloat($('#amount_'+row_id).val(isNaN(NetTotalAmount) ? 0:  NetTotalAmount.toFixed(2)));
    totalSummation();
}
function filghtADDCaculation(row_id){
    var fare        = isNaN($('#fare_'+row_id).val()) ? 0 : parseFloat($('#fare_'+row_id).val());
    var tax         = isNaN($('#tax_'+row_id).val()) ? 0 : parseFloat($('#tax_'+row_id).val());
    var commission  = isNaN($('#commission_'+row_id).val()) ? 0 : parseFloat($('#commission_'+row_id).val());
    var ait         = isNaN($('#ait_'+row_id).val()) ? 0 : parseFloat($('#ait_'+row_id).val());
    var add         = isNaN($('#add_'+row_id).val()) ? 0 : parseFloat($('#add_'+row_id).val());
    var NetTotalAmount = parseFloat((fare+tax+ait+add)- commission);
    parseFloat($('#amount_'+row_id).val(isNaN(NetTotalAmount) ? 0:  NetTotalAmount.toFixed(2)));
    totalSummation();
}

function TotalEmptycheck(row_id){

    var fare        = isNaN($('#fare_'+row_id).val()) ? 0 : parseFloat($('#fare_'+row_id).val());
    var tax         = isNaN($('#tax_'+row_id).val()) ? 0 : parseFloat($('#tax_'+row_id).val());
    var commission  = isNaN($('#commissionPer_'+row_id).val()) ? 0 : parseFloat($('#commissionPer_'+row_id).val());
    var ait         = isNaN($('#aitPer_'+row_id).val()) ? 0 : parseFloat($('#aitPer_'+row_id).val());
    var add         = isNaN($('#add_'+row_id).val()) ? 0 : parseFloat($('#add_'+row_id).val());

    var commissionAmount = (fare*commission)/100;
    var AITAmount = (fare*ait)/100;

    var NetTotalEmpty = (fare+tax+AITAmount+add)- commissionAmount;

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

 console.log(nextindex);

 if( TotalEmptycheck(nextindex-1) > 0){

    airline_info_all();

    var max = 20;

    if(total_element < max ){
    $(".element1:last").after("<tr class='element1' id='flightAreaDiv_"+ nextindex +"'></tr>");

    $("#flightAreaDiv_" + nextindex).append('<td class=""> <select class="FlightTd FlightInfo" name="flight_id[]" id="flight_id_'+nextindex+'"><option value=""> Select Flight</option></select></td><td class=""><input name="fare[]" id="fare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="fareTd" placeholder="0.00"/></td> <td class=""><input name="tax[]" id="tax_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="taxTd" placeholder="0.00"/></td><td class=""><input name="total_fare[]" id="totalFare_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="totalFareTd" placeholder="0.00" readonly /></td><td class=""><input name="commission[]" id="commission_'+nextindex+'" type="text" onkeyup="filghtCommissionAITCaculation('+nextindex+')" class="commissionTd" placeholder="0.00"/><input name="commissionPer[]" id="commissionPer_'+nextindex+'" type="hidden"/></td><td class=""><input name="ait[]" id="ait_'+nextindex+'" type="text" onkeyup="filghtCommissionAITCaculation('+nextindex+')" class="aitTd" placeholder="0.00"/><input name="aitPer[]" id="aitPer_'+nextindex+'" type="hidden"/></td><td class=""><input name="add[]" id="add_'+nextindex+'" type="text" onkeyup="filghtADDCaculation('+nextindex+')" class="AddTd" placeholder="0.00"/></td><td class="amountTh"><input name="amount[]" id="amount_'+nextindex+'" type="text" onkeyup="filghtCaculation('+nextindex+')" class="amountTd Amount" placeholder="0.00" readonly/></td><td class="actionTh"> <button type="button" onclick="removeNewFlight('+nextindex+');" class="btn btn-xs btn-danger"><i class="mdi mdi-minus-box-outline"></i> </button></td>');

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
                    var tax        = parseFloat(response.data.flight_data.tax_amount);
                    var total_fare = parseFloat(response.data.flight_data.total_fare);
                    var commission = parseFloat(response.data.flight_data.commission_amount);
                    var ait        = parseFloat(response.data.flight_data.ait_amount);
                    var add        = parseFloat(response.data.flight_data.add);

                   $('#fare_'+lastChar).val(fare.toFixed(2));
                   $('#tax_'+lastChar).val(tax.toFixed(2));
                   $('#totalFare_'+lastChar).val(total_fare.toFixed(2));
                   $('#commission_'+lastChar).val(commission.toFixed(2));
                   $('#ait_'+lastChar).val(ait.toFixed(2));
                   
                   $('#add_'+lastChar).val(add);
                   var total_amount = parseFloat((fare+tax+ait+add)-commission);
                   $('#amount_'+lastChar).val(total_amount.toFixed(2));

                   totalSummation()

             }
             });
 });

 function TotalEmptycheckHotel(row_id){

    var NetTotalEmptyHotel = isNaN($('#amountHotel_'+row_id).val()) ? 0 : parseFloat($('#amountHotel_'+row_id).val());

    return NetTotalEmptyHotel;

}
function HotelCaculation(row_id){
    var amountHotel = isNaN($('#amountHotel_'+row_id).val()) ? 0 : parseFloat($('#amountHotel_'+row_id).val());
    var discountHotel = isNaN($('#discountHotel_'+row_id).val()) ? 0 : parseFloat($('#discountHotel_'+row_id).val());

    var NetTotal = parseFloat(amountHotel-discountHotel);

     parseFloat($('#netTotal_'+row_id).val(isNaN(NetTotal) ? 0:  NetTotal));

    totalSummation();
}

 // addNewHotel

function addNewHotel(){
    var total_element = $(".element2").length;

    var lastid = $(".element2:last").attr("id");
    var split_id = lastid.split("_");
    var nextindex = Number(split_id[1]) + 1;


    if(TotalEmptycheckHotel(nextindex-1) > 0){

       var max = 20;

       if(total_element < max ){
       $(".element2:last").after("<tr class='element2' id='hotelAreaDiv_"+ nextindex +"'></tr>");

       $("#hotelAreaDiv_" + nextindex).append('<td><textarea rows="1" name="details[]" id="details_'+nextindex+'" class="detailsTd" placeholder="Details"></textarea></td><td><input name="amount2[]" id="amountHotel_'+nextindex+'" type="text"  onkeyup="HotelCaculation('+nextindex+')" class="AmountHotel" placeholder="0.00"/></td><td><input name="discount2[]" id="discountHotel_'+nextindex+'" type="text"  onkeyup="HotelCaculation('+nextindex+')" value="0.00" class="DiscountHotel" placeholder="0.00"/></td><td><input name="net_total_row[]" id="netTotal_'+nextindex+'" type="text"  o class="NetamountTd Amount" placeholder="0.00" readonly/></td><td class="actionTh"> <button type="button" onclick="removeNewHotel('+nextindex+');" class="btn btn-xs btn-danger "><i class="mdi mdi-minus-box-outline"></i> </button></td>');

       }

    }else{
        alert("Please Enter Amount");
    }
}
function removeNewHotel(id){
	var deleteindex = id;
	$("#hotelAreaDiv_" + deleteindex).remove();
}

//  Sale Save
 $(document).on("submit","#SaleForm",function (e){
    var target           = $("#target").val();
    var sale_category_id = $("#sale_category_id").val();
    var agent_id         = $("#agent_id").val();
    var invoice_amount   = $("#invoice_amount").val();
    $('#SaleSaveBtn').attr('disabled',true);

    swal({
        title: "Are you sure?",
        text: "You want to Sale!",
        icon: "info",
        buttons: {
            confirm: 'OK',
            cancel: 'Cancel'
        },
        dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {

                    if(agent_id !='' && sale_category_id != '' && invoice_amount > 0){
                        e.preventDefault();
                            $.ajax({
                                url:target +"sale-save",
                                type:"POST",
                                data: new FormData(this),
                                processData: false,
                                contentType: false,
                                success:function(response){
                                    if (response.status == 'success') {
                                        swal("Success", response.msg, "success");
                                        $('#SaleSaveBtn').attr('disabled',false);
                                        window.location.href = target+"sale-invoice/"+response.data;
                                    }else{
                                        swal("Something went wrong", response.msg, "error");
                                    }
                                }
                            });
                    }else{
                        $('#SaleSaveBtn').attr('disabled',false);
                        swal("Something went wrong","Agent Cannot be Empty", "error");
                    }
                } else {
                        $('#SaleSaveBtn').attr('disabled',false);
                        swal("Sale information is safe!");
                }
        });
});

// update Sale
$(document).on("submit","#SaleFormUpdate",function (e){
    var target           = $("#target").val();
    var id               = $("#id").val();
    var sale_category_id = $("#sale_category_id").val();
    var agent_id         = $("#agent_id").val();
    var invoice_amount   = $("#invoice_amount").val();
    $('#SaleSaveBtn').attr('disabled',true);

    swal({
        title: "Are you sure?",
        text: "You want to Sale Update!",
        icon: "info",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {

                    if(agent_id !='' && sale_category_id != '' && invoice_amount > 0){
                        e.preventDefault();
                            $.ajax({
                                url:target +"sale-update",
                                type:"POST",
                                data: new FormData(this),
                                processData: false,
                                contentType: false,
                                success:function(response){
                                    if (response.status == 'success') {
                                        swal("Success", response.msg, "success");
                                        $('#SaleSaveBtn').attr('disabled',false);
                                        window.location.href = target+"sale-invoice/"+response.data;
                                    }else{
                                        swal("Something went wrong", response.msg, "error");
                                    }
                                }
                            });
                    }else{
                        $('#SaleSaveBtn').attr('disabled',false);
                
                        swal("Something went wrong","Field Cannot be Empty", "error");
                    }
                } else {
                        $('#SaleSaveBtn').attr('disabled',false);
                        swal("Sale information is safe!");
                }
        });
});

function printInvoiceBtn(){
    window.print();
}
