@extends('layouts.master')
@section('title', 'Add Menu')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('menu.store')}}" enctype="multipart/form-data">
                @csrf
          <div class="card-body">
            <a href="{{ url('acl-menu/list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Acl Menu  List </a>
            <h4 class="card-title"> Add Menu </h4><br>
            <div class="form-group row">
                <label for="name" class="col-md-1 form-control-label modalLabelText"> Title <span class="text-danger">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="title" id="title" required
                        placeholder="Title">
                </div>

                <label for="name" class="col-md-2 form-control-label modalLabelText"> Link </label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="link" id="link" placeholder="link">
                </div>
           </div>
           <div class="form-group row">
                <label for="name" class="col-md-1 form-control-label modalLabelText"> Menu  </label>
                <div class="col-md-4">
                <select class="form-control form-control-alt" id="parent_id" name="parent_id" >
                        <option value=""> Root</option>
                        @foreach($get_menu_info as $item)
                        <option value="{{ $item->id}}"> {{$item->title}}</option>
                        @endforeach
                    
                    </select>
                </div>

                <label for="name" class="col-md-2 form-control-label modalLabelText"> Glyphicon Icon </label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-alt" name="glyphicon_icon" id="glyphicon_icon" placeholder="Glyphicon Icon ">
                </div>
           </div>
           
           <div class="form-group row">
            <label for="name" class="col-md-1 form-control-label modalLabelText"> Position </label>
            <div class="col-md-4">
               <input type="text" class="form-control form-control-alt" name="display_position" id="display_position" 
                        placeholder="Display Position"> 
            </div>

            <label for="name" class="col-md-2 form-control-label modalLabelText"> Is main menu </label>
            <div class="col-md-4">
                <select class="form-control form-control-alt" id="is_main_menu" name="is_main_menu" required>
                    <option value=""> Select</option>
                    <option value="1"> 1st Step  </option>
                    <option value="2"> 2nd Step  </option>      
                    <option value="3"> 3rd Step  </option>                             
                </select>         
            </div>

           </div>
                
           <div class="form-group row">
           <label for="name" class="col-md-1 form-control-label modalLabelText"> Status <span class="text-danger">*</span></label>
            <div class="col-md-4">
                <select class="form-control form-control-alt" id="is_active" name="is_active" required>
                    <option value=""> Select</option>
                    <option value="1"> Active </option>
                    <option value="2"> Inactive </option>                              
                </select>                             
            </div>
           </div>
           <div class="form-group row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-primary text-white" type="submit"> Save </button>
            </div>
           </div>        
          </div>
         
        </form>
      </div>
    </div>
  </div>
@endsection