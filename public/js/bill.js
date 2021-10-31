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


/*datwpicker*/
jQuery(".mydatepicker").datepicker();
jQuery("#trans_date").datepicker({
autoclose: true,
todayHighlight: true,
format: 'dd-mm-yyyy',
});
jQuery("#payment_date").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
    });

$(document).ready(function(){
    get_bill_collection_info_list();
}); 

// bill collection list
var token_table;

function get_bill_collection_info_list() {
    let target = $("#asset").val();

    token_table = $('#billListTable').DataTable({
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
            url: target + "get_bill_collection_list_data",
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
                title: "Net Amount",
                data: "credit_amount"
            },
            {
                title: "Transaction date",
                data: "trans_date"
            },
            {
                title: "Remarks",
                data: "remarks"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<button class="btn btn-cyan btn-sm text-white BillCollectionEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white BillCollectionDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}

// search bill collection list
function search_bill_collection_reports ()
{
    agent_id    = $("#agent_id").val();
    trans_date  = $("#trans_date").val();

    $("#billListTable").dataTable().fnSettings().ajax.data.agent_id    = agent_id;
    $("#billListTable").dataTable().fnSettings().ajax.data.trans_date  = trans_date;

    token_table.ajax.reload();
}

function AgentBillPaymentData(){
    var target  = $("#target").val();
    id   = $("#AgentId").val();

    $.ajax({
        url:target+"agent_bill_payment_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
            //console.log(response.data);
            $("#due_amount").val(response.data);
        }
    })
}

function BillCurrentDue(){
    var due_amount = $("#due_amount").val();
    var payment_amount = $("#payment_amount").val();
    if(due_amount > 0){
        var cuddentDueAMount = (due_amount - payment_amount);
        $("#current_due_amount").val(cuddentDueAMount.toFixed(2));
    }
}

// Bill Collection modoal open
function ModalBillCollection(){
    $("#AgentId").val('');
    $("#due_amount").val('');
    $("#payment_amount").val('');
    $("#current_due_amount").val('');
    $("#bank_name").val('');
    $("#receipt_cheque_no").val('');
    $("#payment_date").val('');
    $("#remarks").val('');
    $("#id").val('');

    $('#BillCollectionModal').modal('show');
    document.getElementById("BillCollectionSaveBtn").innerHTML = "Payment";
}
function ModalBillCollectionClose(){
    $('#BillCollectionModal').modal('hide');
}


//  Bill Collection Save
$(document).on("submit","#BillCollectionForm",function (e){
    var target  = $("#target").val();
    var agent   = $("#AgentId").val();
    var payment = $("#payment_amount").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(agent !='' && payment> 0){
        e.preventDefault();
            $.ajax({
                url:target +"bill-collection-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#BillCollectionModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#billListTable").DataTable().draw(true);
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

 $(document).on("click",".BillCollectionEdit",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();

    $.ajax({
        url:target+"bill_collection_row_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
            
               // console.log(response.data);
                $("#id").val(response.data.id);
                $("#AgentId").val(response.data.credit_acc);
                $("#due_amount").val(response.data.credit_amount);
                $("#payment_amount").val(response.data.credit_amount);
                $("#current_due_amount").val(response.data.credit_amount);
                $("#receipt_cheque_no").val(response.data.receipt_cheque_no);
                $("#payment_date").val(response.data.trans_date);
                $("#remarks").val(response.data.remarks);
                $('#chequeNoId').show();

                document.getElementById("BillCollectionSaveBtn").innerHTML = "Update";

            $("#BillCollectionModal").modal('show');
        }
    })
});



// bill delete 
$(document).on("click",".BillCollectionDelete",function(){
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
                        url:target+ "bill_collection_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#billListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        
                        swal("Bill information is safe!");
                    }
        });
});

