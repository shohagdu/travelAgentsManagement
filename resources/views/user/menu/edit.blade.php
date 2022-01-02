@extends('layouts.master')
@section('title', 'Menu Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="{{ route('menu.update', $menu_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
          <div class="card-body">
            <a href="{{ url('acl-menu-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Acl Menu  List </a>
            <h4 class="card-title"> Add Update </h4><br>
            <div class="form-group row">
                <label for="name" class="col-md-1 form-control-label modalLabelText"> Title <span class="text-danger">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="title" id="title" required
                        value="{{$menu_info->title}}">
                </div>

                <label for="name" class="col-md-2 form-control-label modalLabelText"> Link </label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="link" id="link" value="{{$menu_info->link}}">
                </div>
           </div>
           <div class="form-group row">
                <label for="name" class="col-md-1 form-control-label modalLabelText"> Menu  </label>
                <div class="col-md-4">
                <select class="form-control form-control-alt" id="parent_id" name="parent_id" >
                        <option value="" > Root</option>
                        @foreach($get_menu_info as $item)
                        <option value="{{ $item->id}}" <?php if($menu_info->parent_id== $item->id){ echo "selected";}?>> {{$item->title}}</option>
                        @endforeach
                    
                    </select>
                </div>

                <label for="name" class="col-md-2 form-control-label modalLabelText"> Glyphicon Icon </label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="glyphicon_icon" id="glyphicon_icon" value="{{$menu_info->glyphicon_icon}}">
                </div>
           </div>
           
           <div class="form-group row">
            <label for="name" class="col-md-1 form-control-label modalLabelText"> Position </label>
            <div class="col-md-4">
               <input type="text" class="form-control form-control-alt" name="display_position" id="display_position"  value="{{$menu_info->display_position}}"> 
            </div>

            <label for="name" class="col-md-2 form-control-label modalLabelText"> Is main menu </label>
            <div class="col-md-4">
                <select class="form-control form-control-alt" id="is_main_menu" name="is_main_menu" required>
                    <option value=""> Select</option>
                    <option value="1" <?php if($menu_info->is_main_menu==1){ echo "selected";}?>> 1st Step  </option>
                    <option value="2" <?php if($menu_info->is_main_menu==2){ echo "selected";}?>> 2nd Step  </option>      
                    <option value="3" <?php if($menu_info->is_main_menu==3){ echo "selected";}?>> 3rd Step  </option>                             
                </select>         
            </div>

           </div>
                
           <div class="form-group row">
           <label for="name" class="col-md-1 form-control-label modalLabelText"> Status <span class="text-danger">*</span></label>
            <div class="col-md-4">
                <select class="form-control form-control-alt" id="is_active" name="is_active" required>
                    <option value=""> Select</option>
                    <option value="1" <?php if($menu_info->is_active==1){ echo "selected";}?>> Active </option>
                    <option value="2" <?php if($menu_info->is_active==2){ echo "selected";}?>> Inactive </option>                          
                </select>                             
            </div>
           </div>
           
           <div class="form-group row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-info" type="submit"> Update </button><br>
            </div>
           </div>        
          </div>
         
        </form>
      </div>
    </div>
  </div>
@endsection