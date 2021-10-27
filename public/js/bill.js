var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function PaymentMethod(id){
    
    if(id==1){
        $('#chequeNoId').show();
        $('#BankNameId').hide();
    }else if(id==2){
        $('#chequeNoId').show();
        $('#BankNameId').show();
      
    }else{
        $('#chequeNoId').hide();
        $('#BankNameId').hide();
    }
}

function ModalBillCollection(){
    $('#BillCollectionModal').modal('show');
}
function ModalBillCollectionClose(){
    $('#BillCollectionModal').modal('hide');
}

/*datwpicker*/
jQuery(".mydatepicker").datepicker();
jQuery("#trans_date").datepicker({
autoclose: true,
todayHighlight: true,
});