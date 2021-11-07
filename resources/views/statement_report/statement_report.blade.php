@extends('layouts.master')
@section('title', 'Statement Report')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css"href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>
<link href="{{ asset('public/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/>       
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
            <div class="col-sm-2"><br>
               <h5> Statement Report</h5>
            </div>
          <div class="col-sm-2">
              <label>Type</label>
                <select name="type" id="type" class="form-control">
                    <option value=""> Select </option>
                    <option value="1"> Sale </option>
                    <option value="2"> Collection </option>
                    <option value="3"> Refund </option>
                </select>
          </div>  
          <div class="col-sm-2">
              <label> Agent </label>
              <select name="agent_id" id="agent_id" class="form-control">
                  <option value=""> Select </option>
                  @foreach ($agent_info as $item )
                  <option value="{{$item->id}}"> {{$item->name}} </option>
                  @endforeach
              </select>
          </div>
        <div class="col-sm-2">
          <label> From Date </label>
            <input type="text" class="form-control" name="from_date" id="from_date" placeholder="dd-mm-yyyy" autocomplete="off">
        </div>
        <div class="col-sm-2">
          <label> To Date </label>
            <input type="text" class="form-control" name="to_date" id="to_date" placeholder="dd-mm-yyyy" autocomplete="off">
        </div>
        <div class="col-sm-1">
          <label> &nbsp;</label>
            <button onclick="search_statement_report_reports()" id="" class="btn btn-success text-white">Search</button>
        </div>
      </div>
      <table id="StatementReportListTable" class="table table-bordered">
  
      </table>
    </div>
  </div>
</div>


@endsection
@section('js')
<!-- DataTables  -->
<script src="{{ asset('public/assets/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/assets/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('public/assets/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('public/assets/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('public/js/report.js')}}"></script>
@endsection