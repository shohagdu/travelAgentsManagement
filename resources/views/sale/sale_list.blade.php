@extends('layouts.master')
@section('title', 'Sale List')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css')}}"> 
<!-- Select2 -->
<link rel="stylesheet" type="text/css"href="{{ asset('assets/libs/select2/dist/css/select2.min.css')}}"/>    

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
        <input type="hidden" name="asset" id="asset" value="{{ asset('')}}">
        <div class="form-group row">
          <label for="currency" class="col-sm-2 text-end control-label col-form-label"> Sale Category</label>
          <div class="col-sm-2">
            <select name="sale_category_id" id="sale_category_id" class="form-control @error('sale_category_id') is-invalid @enderror">
              <option value=""> Select</option>
              <option value="1"> Flights </option>
              <option value="2"> Hotels </option>
              <option value="3"> Transfers </option>
              <option value="4"> Activities </option>
              <option value="5"> Holidays </option>
              <option value="6"> Visa </option>
              <option value="7"> Others </option>
          </select>
          </div>
          <label for="agent_id" class="col-sm-1 text-end control-label col-form-label"> Agent</label>
          <div class="col-sm-2">
              <select name="agent_id" id="agent_id" class="select2 form-select shadow-none">
                  <option value=""> Select </option>
                  @foreach ($agent_info as $item )
                  <option value="{{$item->id}}"> {{$item->name}} </option>
                  @endforeach  
              </select>
          </div>
          <div class="col-sm-1">
            <button onclick="search_sale_reports()" id="" class="btn btn-primary">Search</button>
        </div>
      </div><br>

      <h5 class="card-title mb-0"> Sale List </h5><br>
      <div class="table-responsive">
        <table id="sale_list_table" class="table table-bordered table-striped">
          
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<!-- DataTables  -->
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('js/sale.js')}}"></script>
@endsection