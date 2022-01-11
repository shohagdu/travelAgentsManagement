var url  = $('meta[name = path]').attr("content");
var csrf = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
jQuery(".mydatepicker").datepicker();
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

// IATA debit modoal open
function AddIATADebit(){
    $("#amount").val('');
    $("#transaction_date").val('');
    $("#remarks").val('');
    $("#id").val('');

    $('#IATADebitModal').modal('show');
    document.getElementById("BillCollectionSaveBtn").innerHTML = "Submit";
}

function ModalIATAClose(){
    $('#IATADebitModal').modal('hide');
}


$(document).ready(function(){
    get_iata_debit_info_list();
}); 

// iata debit  list
var iata_table;

function get_iata_debit_info_list() {
    let target = $("#asset").val();
    iata_table = $('#IATADebitListTable').DataTable({
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
            url: target + "get_iata_debit_list_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return iata_table.page.info().start + iata_table.column(0).nodes().length;
                }           
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
        
                    return '<button class="btn btn-cyan btn-sm text-white IATADebitEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white IATADebitDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}

// search iata debit list
function search_iata_debit_reports ()
{
    trans_date = $("#trans_date").val();
    $("#IATADebitListTable").dataTable().fnSettings().ajax.data.trans_date = trans_date;
    iata_table.ajax.reload();
}

//  IATA debit Save
$(document).on("submit","#IATADebitForm",function (e){
    var target  = $("#target").val();
    var amount  = $("#amount").val();
    var transaction_date = $("#transaction_date").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(amount > 0 && transaction_date !=''){
        e.preventDefault();
            $.ajax({
                url:target +"iata-debit-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#IATADebitModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#IATADebitListTable").DataTable().draw(true);
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

 $(document).on("click",".IATADebitEdit",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    $.ajax({
        url:target+"iata_debit_row_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
               // console.log(response.data);
                $("#id").val(response.data.id);
                $("#amount").val(response.data.amount);
                $("#transaction_date").val(response.data.date);
                $("#remarks").val(response.data.remarks);

                document.getElementById("BillCollectionSaveBtn").innerHTML = "Update";

            $("#IATADebitModal").modal('show');
        }
    })
});

// iata debit delete 
$(document).on("click",".IATADebitDelete",function(){
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
                        url:target+ "iata_debit_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#IATADebitListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        swal("IATA debit information is safe!");
                }
        });
});


$(document).ready(function(){
    get_iata_credit_info_list();
}); 

// iata debit  list
var iata_table;

function get_iata_credit_info_list() {
    let target = $("#asset").val();
    iata_table = $('#IATACreditListTable').DataTable({
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
            url: target + "get_iata_credit_list_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return iata_table.page.info().start + iata_table.column(0).nodes().length;
                }           
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
        
                    return '<button class="btn btn-cyan btn-sm text-white IATADebitEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white IATACreditDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}
//  IATA Credit Save
$(document).on("submit","#IATACreditForm",function (e){
    var target  = $("#target").val();
    var amount  = $("#amount").val();
    var transaction_date = $("#transaction_date").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(amount > 0 && transaction_date !=''){
        e.preventDefault();
            $.ajax({
                url:target +"iata-credit-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#IATADebitModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#IATACreditListTable").DataTable().draw(true);
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

 // iata debit delete 
$(document).on("click",".IATACreditDelete",function(){
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
                        url:target+ "iata_credit_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#IATACreditListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        swal("IATA Credit information is safe!");
                }
        });
});