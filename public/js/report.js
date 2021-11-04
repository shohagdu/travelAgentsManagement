$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var url  = $('meta[name = path]').attr("content");
var csrf = $('mata[name = csrf-token]').attr("content");

function printStatement(){
    window.print();
}
jQuery(".mydatepicker").datepicker();
jQuery("#from_date").datepicker({
autoclose: true,
todayHighlight: true,
format: 'dd-mm-yyyy',
});
jQuery("#to_date").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
    });

$(document).ready(function(){
    get_statement_report_info_list();
}); 

// statement report
var token_table;

function get_statement_report_info_list() {
    let target = $("#asset").val();

    token_table = $('#StatementReportListTable').DataTable({
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
            url: target + "get_statement_report_data",
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
                data: null,
                render: function (data) {
                    if(data.agent_name == null){
                        return data.agent_name2;
                    }
                    else if(data.agent_name2 == null){
                        return  data.agent_name;
                    }
                    
                }
            },
            {
                title: "Remarks",
                data: "remarks"
            },
            {
                title: "Transaction date",
                data: "trans_date"
            },
            {
                title: "Amount",
                data: null,
                render: function (data) {
                    if(data.agent_name == null){
                        return data.debit_amount;
                    }
                    else if(data.agent_name2 == null){
                        return  data.credit_amount;
                    }
                    
                }
            },
        ],
    });
}

// search statement report list
function search_statement_report_reports ()
{
    type      = $("#type").val();
    agent_id  = $("#agent_id").val();
    from_date = $("#from_date").val();
    to_date   = $("#to_date").val();

    $("#StatementReportListTable").dataTable().fnSettings().ajax.data.type        = type;
    $("#StatementReportListTable").dataTable().fnSettings().ajax.data.agent_id    = agent_id;
    $("#StatementReportListTable").dataTable().fnSettings().ajax.data.from_date   = from_date;
    $("#StatementReportListTable").dataTable().fnSettings().ajax.data.to_date     = to_date;

    token_table.ajax.reload();
}


$(document).ready(function(){
    get_account_report_info_list();
}); 

// Account report
var account_table;

function get_account_report_info_list() {
    let target = $("#asset").val();

    account_table = $('#AccountReportListTable').DataTable({
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
            url: target + "get_account_report_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return account_table.page.info().start + account_table.column(0).nodes().length;
                }           
            },
            {
                title: "Account Name",
                data: "account_name"
            },
            {
                title: "Remarks",
                data: "remarks"
            },
            {
                title: "Transaction date",
                data: "trans_date"
            },
            {
                title: "Amount",
                data: "credit_amount"
            },
        ],
    });
}

// search account report list
function search_account_report_reports ()
{
    account_id = $("#account_id").val();
    from_date  = $("#from_date").val();
    to_date    = $("#to_date").val();

    $("#AccountReportListTable").dataTable().fnSettings().ajax.data.account_id  = account_id;
    $("#AccountReportListTable").dataTable().fnSettings().ajax.data.from_date   = from_date;
    $("#AccountReportListTable").dataTable().fnSettings().ajax.data.to_date     = to_date;

    account_table.ajax.reload();
}