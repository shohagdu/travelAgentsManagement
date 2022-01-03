@extends('layouts.master')
@section('title', 'Add Role')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="{{ route('role.role_store')}}" method="POST" enctype="multipart/form-data"><br>
            @csrf
          <div class="card-body">
            <a href="{{ url('acl-role-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Acl Role  List </a>
            <h4 class="card-title"> Add Role </h4><br>
            <div class="form-group row">
                <div class="col-md-1"></div>
                <label for="name" class="col-md-2 form-control-label modalLabelText"> Role Name </label>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-alt" name="role_name" id="role_name" 
                        placeholder="Role Name" required>  
                 </div>

                <label for="name" class="col-md-1 form-control-label modalLabelText"> Status </label>
                <div class="col-md-3">
                    <select class="form-control form-control-alt" id="is_active" name="is_active" required>
                        <option value=""> Select</option>
                        <option value="1"> Active </option>
                        <option value="2"> Inactive </option>                              
                    </select>            
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-info text-white" type="submit"> Save </button>
                </div>    
           </div>
           <hr>
           <div class="form-group row">
           <div class="col-md-1"></div>
           <div class="col-md-4">
           <p><label><input type="checkbox" id="checkAll"/> Check all</label></p>
           </div>
           </div>
         
            @foreach($get_menu_info as $item)
            <div class="form-group row">
                <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <p>  <input type="checkbox" name="role_info[{{$item->id}}]" id="role_info_{{$item->id}}" value="{{$item->id}}" > 
                        <span style="margin-left: 10px; font-weight: bold"> {{$item->title}} </span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
            
                    @if(!empty($item->mainChild))
                        @foreach($item->mainChild as $childKey => $row)
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <p>  <input type="checkbox"  name="role_info[{{$item->id}}][{{$row->id}}]"  value="{{$row->id}}" > 
                            <span style="margin-left: 10px;"> {{$row->title}} </span>
                            </p>
                        </div>
                        @endforeach
                    @endif
           </div>
            @endforeach

           </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
    $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>
@endsection