@extends('layouts.master')
@section('title', 'Agent Record List')
@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet"/>    
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }} alert-dismissible fade show" role="alert">
      {{ session('flash.message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
      <div class="card-body">
        <form method="post" action="" class="form-horizontal" enctype="multipart/form-data" style="padding-right: 100px">
          @csrf
          <input type="hidden" name="asset" id="asset" value="{{ asset('')}}">
        <div class="form-group row">
          <label for="currency" class="col-sm-1 text-end control-label col-form-label"> Country</label>
          <div class="col-sm-2">
              <select name="country" id="country"   onchange="getCity(this.value, 'city_id')" class="select2 form-select shadow-none ">
              <option value=""> Select </option>
              @foreach ($country as $item )
                  <option value="{{$item->id}}"> {{$item->name}} </option>
              @endforeach   
              </select>
          </div>
          <label for="city" class="col-sm-1 text-end control-label col-form-label"> City</label>
          <div class="col-sm-2">
              <select name="city" id="city" class="select2 form-select shadow-none">
                  <option value=""> Select </option>
                  @foreach ($state as $item )
                  <option value="{{$item->id}}"> {{$item->name}} </option>
                  @endforeach  
              </select>
          </div>
          <label for="mobile" class="col-sm-1 text-end control-label col-form-label"> Mobile</label>
          <div class="col-sm-2">
              <input name="mobile" id="mobile" class="form-control" placeholder="Mobile"/>
          </div>
          <div class="col-sm-1">
            <button type="button" onclick="search_agent_list()" id="" class="btn btn-primary">Search</button>
        </div>
      </div><br>

        <h5 class="card-title mb-0"> Agent Record List </h5>
      <div class="table-responsive">
        <table id="agent_list_table" class="table table-striped table-bordered">
          
        </table>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<!-- DataTables -->
<script src="{{ asset('')}}js/jquery.dataTables.min.js"></script>
<script src="{{ asset('')}}js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('js/global.js')}}"></script>
@endsection