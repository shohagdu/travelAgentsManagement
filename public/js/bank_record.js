var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//  select2
$( document ).ready(function() {
    if ($(".select2").length > 0){
        $(".select2").select2();
    }
});

jQuery("#transaction_date").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
    });
jQuery("#trans_date").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
});    

$(document).ready(function(){
    get_debit_bill_info_list();
}); 

// bank debit  list
var bank_table;

function get_debit_bill_info_list() {
    let target = $("#asset").val();

    bank_table = $('#BankDebitListTable').DataTable({
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
            url: target + "get_bank_debit_list_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return bank_table.page.info().start + bank_table.column(0).nodes().length;
                }           
            },
            {
            	title: "Bank Name",
                data:  "bank_name"
            },
            {
                title: "Amount",
                data: "amount"
            },
            {
                title: "Transaction date",
                data: "TransactionDate"
            },
            {
                title: "Remarks",
                data: "remarks"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<button class="btn btn-cyan btn-sm text-white BankDebitEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white BankDebitDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}

// search bank debit list
function search_bank_debit_reports ()
{
    bank_id    = $("#bank_id").val();
    trans_date = $("#trans_date").val();

    $("#BankDebitListTable").dataTable().fnSettings().ajax.data.bank_id    = bank_id;
    $("#BankDebitListTable").dataTable().fnSettings().ajax.data.trans_date = trans_date;

    bank_table.ajax.reload();
}


// bank debit modoal open
function AddBankDebit(){
    $("#BanktId").val('');
    $("#amount").val('');
    $("#transaction_date").val('');
    $("#remarks").val('');
    $("#id").val('');

    $('#BankDebitModal').modal('show');
    document.getElementById("BillCollectionSaveBtn").innerHTML = "Submit";
}
function ModalModalDebitClose(){
    $('#BankDebitModal').modal('hide');
}

//  Bank debit Save
$(document).on("submit","#BankDebitForm",function (e){
    var target  = $("#target").val();
    var bank_id   = $("#BanktId").val();
    var amount  = $("#amount").val();
    var transaction_date = $("#transaction_date").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(bank_id !='' && amount > 0 && transaction_date !=''){
        e.preventDefault();
            $.ajax({
                url:target +"bank-debit-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#BankDebitModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#BankDebitListTable").DataTable().draw(true);
                    }else{
                        swal("Something went wrong", response.msg, "error");
                    }
                }
            });
    }else{
        $('#BillCollectionSaveBtn').attr('disabled',false);
        swal("Something went wrong","Field Cannot be Empty", "error");
    }
 });


 $(document).on("click",".BankDebitEdit",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    $.ajax({
        url:target+"bank_debit_row_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
               // console.log(response.data);
                $("#id").val(response.data.id);
                $("#BanktId").val(response.data.bank_id);
                $("#amount").val(response.data.amount);
                $("#transaction_date").val(response.data.transaction_date);
                $("#remarks").val(response.data.remarks);

                document.getElementById("BillCollectionSaveBtn").innerHTML = "Update";

            $("#BankDebitModal").modal('show');
        }
    })
});

// bank debit delete 
$(document).on("click",".BankDebitDelete",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    swal({
        title: "Are you sure?",
        text: "You want to Delete!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {
                    $.ajax({
                        url:target+ "bank_debit_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#BankDebitListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        
                        swal("Bank debit information is safe!");
                    }
        });
});

// bank debit modoal open
function AddBankCredit(){
    $("#BanktId").val('');
    $("#amount").val('');
    $("#transaction_date").val('');
    $("#remarks").val('');
    $("#id").val('');

    $('#BankCreditModal').modal('show');
    document.getElementById("BillCollectionSaveBtn").innerHTML = "Submit";
}
function ModalModalDebitClose(){
    $('#BankCreditModal').modal('hide');
}


$(document).ready(function(){
    get_credit_bill_info_list();
}); 

// bank debit  list
var bank_table2;

function get_credit_bill_info_list() {
    let target = $("#asset").val();

    bank_table2 = $('#BankCreditListTable').DataTable({
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
            url: target + "get_bank_credit_list_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return bank_table2.page.info().start + bank_table2.column(0).nodes().length;
                }           
            },
            {
            	title: "Bank Name",
                data:  "bank_name"
            },
            {
                title: "Amount",
                data: "amount"
            },
            {
                title: "Transaction date",
                data: "TransactionDate"
            },
            {
                title: "Remarks",
                data: "remarks"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<button class="btn btn-cyan btn-sm text-white BankCreditEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white BankCreditDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}

// search bank credit list
function search_bank_credit_reports ()
{
    bank_id    = $("#bank_id").val();
    trans_date = $("#trans_date").val();

    $("#BankCreditListTable").dataTable().fnSettings().ajax.data.bank_id    = bank_id;
    $("#BankCreditListTable").dataTable().fnSettings().ajax.data.trans_date = trans_date;

    bank_table2.ajax.reload();
}

//  Bank debit Save
$(document).on("submit","#BankCreditForm",function (e){
    var target  = $("#target").val();
    var bank_id   = $("#BanktId").val();
    var amount  = $("#amount").val();
    var transaction_date = $("#transaction_date").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(bank_id !='' && amount > 0 && transaction_date !=''){
        e.preventDefault();
            $.ajax({
                url:target +"bank-credit-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#BankCreditModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#BankCreditListTable").DataTable().draw(true);
                    }else{
                        swal("Something went wrong", response.msg, "error");
                    }
                }
            });
    }else{
        $('#BillCollectionSaveBtn').attr('disabled',false);
        swal("Something went wrong","Field Cannot be Empty", "error");
    }
 });

 $(document).on("click",".BankCreditEdit",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    $.ajax({
        url:target+"bank_credit_row_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
               // console.log(response.data);
                $("#id").val(response.data.id);
                $("#BanktId").val(response.data.bank_id);
                $("#amount").val(response.data.amount);
                $("#transaction_date").val(response.data.transaction_date);
                $("#remarks").val(response.data.remarks);

                document.getElementById("BillCollectionSaveBtn").innerHTML = "Update";

            $("#BankCreditModal").modal('show');
        }
    })
});

// bank debit delete 
$(document).on("click",".BankCreditDelete",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    swal({
        title: "Are you sure?",
        text: "You want to Delete!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {
                    $.ajax({
                        url:target+ "bank_credit_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#BankCreditListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        
                        swal("Bank Credit information is safe!");
                    }
        });
});
