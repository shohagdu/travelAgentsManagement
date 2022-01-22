@extends('layouts.master')
@section('title', 'Expense')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>
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
            <div class="col-sm-2">
               <h4> Expense </h4>
            </div>
        <label for="trans_date" class="col-sm-1 text-end control-label col-form-label"> Date </label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="trans_date" id="trans_date" placeholder="dd-mm-yyyy" autocomplete="off">
        </div>
        <div class="col-sm-3">
            <button onclick="search_expense_reports()" id="" class="btn btn-primary">Search</button>
        </div>
        <div class="col-sm-3">
        <h5 class="card-title mb-0 ">    <button class="btn btn-success btn-sm text-white rightButton" onclick="AddExpense()">
          <i class="mdi mdi-plus-box"></i> Add Expense </button> 
        </h5>
        </div>
      </div>
      <table id="ExpenseListTable" class="table table-bordered">
  
      </table>
    </div>
  </div>
  <!-- Expense  modal -->
<div class="modal fade" id="ExpenseModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <form method="post" id="ExpenseForm"  action="javascript:void(0)" >
    @csrf
  <div class="modal-dialog modal-lg ">
    <div class="modal-content ">
      <div class="modal-header">
        <h4 class="modal-title" id="ExpenseModalLabel">New Expense</h4>
        <button onclick="ModalExpenseClose()" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="category_id" class="col-sm-3 text-end control-label col-form-label">Expense Category </label>
          <div class="col-sm-9">
              <select name="category_id" id="category_id" class="form-control">
                    <option value="">Select</option>
                    @foreach($category_info as $item)
                    <option value="{{ $item->id}}">{{ $item->title}}</option>
                    @endforeach
              </select>
          </div>
        </div>   
        <div class="form-group row">
          <label for="amount" class="col-sm-3 text-end control-label col-form-label"> Amount </label>
          <div class="col-sm-9">
            <input type="text" name="amount" id="amount" class="form-control" autocomplete="off" placeholder="0.00">
          </div>
        </div>
        <div class="form-group row">
          <label for="transaction_date" class="col-sm-3 text-end control-label col-form-label">  Date </label>
          <div class="col-sm-9">
            <div class="input-group">
              <input name="transaction_date" type="text" class="form-control" id="transaction_date"  placeholder="dd-mm-yyyy"  autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-text h-100"><i class="mdi mdi-calendar"></i></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="remarks" class="col-sm-3 text-end control-label col-form-label"> Remarks </label>
          <div class="col-sm-9">
            <textarea name="remarks" id="remarks" class="form-control"></textarea> 
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="target" id="target" value="{{ asset('')}}">
        <input type="hidden" name="id" id="id">
        <button type="submit" id="BillCollectionSaveBtn" class="btn btn-primary">  Submit  </button>
        <button onclick="ModalExpenseClose()" type="button" class="btn btn-danger" data-dismiss="modal">  <i class="far fa-window-close"></i></button>
      </div>
    </div>
  </div>
  </form>
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
<script src="{{ asset('public/js/sweetalert.min.js')}}"></script>
<script src="{{ asset('public/js/expense.js')}}"></script>
@endsection