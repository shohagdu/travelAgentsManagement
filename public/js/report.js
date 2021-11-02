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