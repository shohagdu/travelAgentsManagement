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
 
// Expense modoal open 
function AddExpense(){
    $("#category_id").val('');
    $("#amount").val('');
    $("#transaction_date").val('');
    $("#remarks").val('');
    $("#id").val('');

    $('#ExpenseModal').modal('show');
    document.getElementById("BillCollectionSaveBtn").innerHTML = "Submit";
}

function ModalExpenseClose(){
    $('#ExpenseModal').modal('hide');
}


$(document).ready(function(){
    get_expense_info_list();
}); 

// Expense  list
var expense_table;

function get_expense_info_list() {
    let target = $("#asset").val();
    expense_table = $('#ExpenseListTable').DataTable({
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
            url: target + "get_expense_list_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return expense_table.page.info().start + expense_table.column(0).nodes().length;
                }           
            },
            {
                title: "Category Name",
                data: "title"
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
        
                    return '<button class="btn btn-cyan btn-sm text-white ExpenseEdit" data-id="'+data.id+'"> <span class="mdi mdi-pencil-box-outline"></span>Edit </button>  <button class="btn btn-danger btn-sm text-white ExpenseDelete" data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
                }
            },
        ],
    });
}

// search expense list
function search_expense_reports ()
{
    trans_date = $("#trans_date").val();
    $("#ExpenseListTable").dataTable().fnSettings().ajax.data.trans_date = trans_date;
    expense_table.ajax.reload();
}

//  Expense Save
$(document).on("submit","#ExpenseForm",function (e){
    var target      = $("#target").val();
    var amount      = $("#amount").val();
    var category_id = $("#category_id").val();
    var transaction_date = $("#transaction_date").val();
    $('#BillCollectionSaveBtn').attr('disabled',true);

    if(amount > 0 && transaction_date !='' && category_id > 0){
        e.preventDefault();
            $.ajax({
                url:target +"expense-save",
                type:"POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success:function(response){
                    if (response.status == 'success') {
                        swal("Success", response.msg, "success");
                        $("#ExpenseModal").modal('hide');
                        $('#BillCollectionSaveBtn').attr('disabled',false);
                        $("#ExpenseListTable").DataTable().draw(true);
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

 $(document).on("click",".ExpenseEdit",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    $.ajax({
        url:target+"expense_row_data",
        type:"POST",
        data:{
            id: id
        },
        success:function(response){
               // console.log(response.data);
                $("#id").val(response.data.id);
                $("#category_id").val(response.data.category_id);
                $("#amount").val(response.data.amount);
                $("#transaction_date").val(response.data.date);
                $("#remarks").val(response.data.remarks);

                document.getElementById("BillCollectionSaveBtn").innerHTML = "Update";

            $("#ExpenseModal").modal('show');
        }
    })
});

// iata debit delete 
$(document).on("click",".ExpenseDelete",function(){
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
                        url:target+ "expense_delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#ExpenseListTable").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        swal("Expense information is safe!");
                }
        });
});    