$.ajaxSetup({
    
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var url  = $('meta[name = path]').attr("content");
var csrf = $('mata[name = csrf-token]').attr("content");


$(document).ready(function(){
    get_agent_info_list();
    $(".select2").select2();
  }); 




// agent list
var token_table;

function get_agent_info_list() {
    let target = $("#asset").val();

    token_table = $('#agent_list_table').DataTable({
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
            url: target + "get_agent_list_data",
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
            	title: "Name",
                data: "name"
            },
            {
                title: "Mobile",
                data: "mobile"
            },
            {
                title: "Email",
                data: "email"
            },
            {
                title: "Country Name",
                data: "country_name"
            },
            {
                title: "City Name",
                data: "city_name"
            },
            {
            	title: "Action",
                data: null,
                render: function(data, type, row, meta){
                 
                    return '<a href="'+target+'agent-edit/'+ data.id+'" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>Edit </a> <a href="'+target+'agent-statement/'+ data.id+'" class="btn btn-info btn-sm text-white"> <span class="mdi mdi-format-list-bulleted"></span> Statement </a>  <a onclick="return confirm(\'Are you sure you want to delete?\')" href="'+target+'agent-delete/'+ data.id+'" class="btn btn-danger btn-sm text-white"><span class="mdi mdi-delete-circle"></span>  Delete </a>';
                }
            },
        ],
    });
}

// search agent report
function search_agent_reports ()
{
    country  = $("#country").val();
    city     = $("#city").val();
    mobile   = $("#mobile").val();

    $("#agent_list_table").dataTable().fnSettings().ajax.data.country = country;
    $("#agent_list_table").dataTable().fnSettings().ajax.data.city    = city;
    $("#agent_list_table").dataTable().fnSettings().ajax.data.mobile  = mobile;

    token_table.ajax.reload();
  }
  