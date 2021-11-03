var url  = $('meta[name = path]').attr("content");
var csrf    = $('mata[name = csrf-token]').attr("content");
$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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
                    else if(data.sale_category_id==3){
                        return 'Transfers';
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
                title: "Net Total",
                data: "sale_amount"
            },
            {
                title: "Discount",
                data: "discount"
            },
            {
                title: "Invoice Amount",
                data: "amount"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<a href="'+target+'sale-edit/'+data.id+'" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>Edit </a> <a href="'+target+'sale-invoice/'+data.id+'" class="btn btn-info btn-sm text-white"> <span class="mdi mdi-file-document-box"></span>Invoice </a> <button class="btn btn-danger btn-sm text-white SaleDelete " data-id="'+data.id+'"><span class="mdi mdi-delete-circle"></span>  Delete </button>';
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

// sale delete
$(document).on("click",".SaleDelete",function(){
    let id = $(this).data('id');
    var target  = $("#target").val();
    swal({
        title: "Are you sure?",
        text: "You want to Sale Delete!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {
                   
                    $.ajax({
                        url:target+ "sale-delete",
                        type:"POST",
                        data:{
                            id: id
                        },
                        success:function(responseText){
                            if(responseText.status == 'success'){
                                swal("Success", responseText.msg, "success");
                                $("#sale_list_table").DataTable().draw(true);
                            }
                            else{
                                swal("Sorry", responseText.msg, "error");
                            }
                        }
                    });
                    } else {
                        
                        swal("Sale information is safe!");
                    }
        });
});
