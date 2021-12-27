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
    get_agent_wise_statement_report_info_list();
});

// agent date wise statement report
var token_table2;

function get_agent_wise_statement_report_info_list() {
    let target = $("#asset").val();
    var balance = 0;
    token_table2 = $('#AgentStatementReportListTable').DataTable({
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
            url: target + "get_agent_date_wise_statement_data",
            data: {
               // _token : user_csrf
            },
        },
        columns:[
             {
             	title: "SL",
                data: null,
                render: function(){
                    return token_table2.page.info().start + token_table2.column(0).nodes().length;
                }
            },
            {
                title: "Date",
                data: "trans_date"
            },
            {
                title: "Transaction Details",
                data: null,
                render: function (data) {
                    if(data.agent_name == null){
                        var name =  data.agent_name2;
                    }
                    else if(data.agent_name2 == null){
                        var name=  data.agent_name;
                    }

                    if(data.trans_type == 1){
                        return "Sale >> "+data.invoice_no+" >>"+data.category_name+" >> "+name+ " >>"+data.transRemark;
                    }
                    else if(data.trans_type == 2){
                        return "Credit >> "+name+ " >> "+data.reference_number+" >> "+data.transRemark;
                    }
                    else if(data.trans_type == 3){
                        return "Debit >> "+name+ " >> "+data.transRemark;
                    }
                }
            },
            {
                title: "Debit",
                data: null,
                render: function (data) {
                    if(data.trans_type ==1 || data.trans_type ==3 ){
                        var dr = data.debit_amount;
                        return dr ;
                       // var dr_total += data.debit_amount;
                    }else{
                        var dr = '0.00';
                        return "-";
                    }
                }
            },
            {
                title: "Credit",
                data: null,
                render: function (data) {
                    if(data.trans_type ==2){
                        var cr = data.credit_amount;
                        return  cr;
                        // var cr_total += data.credit_amount;
                    }else{
                     var cr  = '0.00';
                     return "-";
                    }
                }
            },
            {
                title: "Balance",
                data: null,
                render: function (data) {
                  return balance;
                }
            },
        ],
    });
}

// search agent date wise statement report list
function search_agent_date_wise_statement_report_reports ()
{
    agent_id  = $("#agent_id").val();
    from_date = $("#from_date").val();
    to_date   = $("#to_date").val();

    $("#AgentStatementReportListTable").dataTable().fnSettings().ajax.data.agent_id    = agent_id;
    $("#AgentStatementReportListTable").dataTable().fnSettings().ajax.data.from_date   = from_date;
    $("#AgentStatementReportListTable").dataTable().fnSettings().ajax.data.to_date     = to_date;

    token_table2.ajax.reload();
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

function searchAgentStatementBtn(){
    $(".showReports").html('')
   // $('#searchAgentStatement').attr('disabled',true);
    $.ajax({
        url:"agentStatementAction",
        type:"POST",
        // dataType:"json",
        data: $("#agentStatementForm").serialize(),
        processData: false,
        // contentType: false,
        success:function(response){
            console.log(response);
            $('#searchAgentStatement').attr('disabled',false);
            if (response != '') {
                $(".showReports").html(response)
            }else{
                $("#showReports").html('')
            }
        }
    });

}

function search_statement_reports ()
{
    $(".showReports").html('')
     $('#searchStatement').attr('disabled',true);
    $.ajax({
        url:"dailyStatementAction",
        type:"POST",
        data: $("#agentStatementForm").serialize(),
        processData: false,
        // contentType: false,
        success:function(response){
            $('#searchStatement').attr('disabled',false);
            if (response != '') {
                $(".showReports").html(response)
            }else{
                $("#showReports").html('')
            }
        }
    });
}
