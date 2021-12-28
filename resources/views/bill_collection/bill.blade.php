@extends('layouts.master')
@section('title', 'Credit Bill')
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
            <div class="col-sm-2">
               <h4>Credit Bill</h4>
            </div>

          <label for="agent_id" class="col-sm-1 text-end control-label col-form-label"> Agent</label>
          <div class="col-sm-3">
              <select name="agent_id" id="agent_id" class="select2 form-select shadow-none">
                  <option value=""> Select </option>
                  @foreach ($agent_info as $item )
                  <option value="{{$item->id}}"> {{$item->name}} ({{ $item->company_name}}) </option>
                  @endforeach
              </select>
          </div>
        <label for="currency" class="col-sm-1 text-end control-label col-form-label"> Date </label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="trans_date" id="trans_date" placeholder="dd-mm-yyyy" autocomplete="off">
        </div>
          <div class="col-sm-1">
            <button onclick="search_bill_collection_reports()" id="" class="btn btn-primary">Search</button>
        </div>

        <h5 class="card-title mb-0 lefttButtonText">    <button class="btn btn-success btn-sm text-white rightButton" onclick="ModalBillCollection()">
          <i class="mdi mdi-plus-box"></i> Add Credit Bill </button></h5>
      
      </div>
      <table id="billListTable" class="table table-bordered">
  
      </table>
    </div>
  </div>
  <!-- Bill  modal -->
<div class="modal fade" id="BillCollectionModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <form method="post" id="BillCollectionForm"  action="javascript:void(0)" >
    @csrf
  <div class="modal-dialog modal-lg ">
    <div class="modal-content ">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Credit Bill</h4>
        <button onclick="ModalBillCollectionClose()" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table style="width: 80%; margin-left: 100px; font-weight: 600">
          <tr>
            <td> Name :   <span id="AgentNameTxt"> </span> </td>
            <td> Due Amount  : <span id="dueAmount"> </span></td>
          </tr>
          <tr>
            <td> Address : <span id="AgentAddressTxt"> </span>  </td>
            <td> Company Name   : <span id="AgentCompanyTxt"> </span>  </td>
          </tr>
        </table><br>
  
        {{-- <p style="text-align: center">
          <span> Name : <span id="AgentNameTxt"> </span><br>
          <span> Balance : </span> <span id="Balance"></span> <br>
          <span> Due Amount : </span>  <span id="dueAmount"><br>
         </p> --}}
        <div class="form-group row">
          <label for="agent_id" class="col-sm-3 text-end control-label col-form-label"> Agent Name</label>
          <div class="col-sm-9">
              <select id="AgentId" name="agent_id" onchange="AgentBillPaymentData()" class="form-control">
                <option value=""> Select Agent </option>
                @foreach ($agent_info as $item)
                  <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                @endforeach
             </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="towards_type" class="col-sm-3 text-end control-label col-form-label"> Credit Towards</label>
          <div class="col-sm-9">
              <select id="towards_type" name="towards_type"  class="form-control">
                <option value=""> Select Towards </option>
                @foreach ($category_info as $item)
                  <option value="{{ $item->id}}"> {{ $item->title}} </option> 
                @endforeach
             </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="reference_number" class="col-sm-3 text-end control-label col-form-label"> Reference Number</label>
          <div class="col-sm-9">
            <input type="text" name="reference_number" id="reference_number" class="form-control"  placeholder="Reference Number">
          </div>
        </div>
        <div class="form-group row">
          <label for="payment_amount" class="col-sm-3 text-end control-label col-form-label"> Credit Amount </label>
          <div class="col-sm-9">
            <input type="text" name="payment_amount" id="payment_amount"  onkeyup="BillCurrentDue()" class="form-control" autocomplete="off" placeholder="0.00">
          </div>
        </div>
        {{-- <div class="form-group row" id="BankNameId">
          <label for="bank_name" class="col-sm-3 text-end control-label col-form-label"> Account Name</label>
          <div class="col-sm-9">
              <select id="bank_name" name="bank_name" class="form-control" >
                <option value=""> Select Account  </option>
                @foreach ($bank as $item )
                <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                @endforeach
            </select>
          </div>
        </div> --}}
        {{-- <div class="form-group row">
          <label for="receipt_cheque_no" class="col-sm-3 text-end control-label col-form-label"> Receipt/Cheque No</label>
          <div class="col-sm-9">
            <input type="text" name="receipt_cheque_no" id="receipt_cheque_no" class="form-control"  placeholder="Receipt/Cheque No">
          </div>
        </div> --}}
        <div class="form-group row">
          <label for="payment_date" class="col-sm-3 text-end control-label col-form-label"> Payment Date </label>
          <div class="col-sm-9">
            <div class="input-group">
              <input name="payment_date" type="text" class="form-control" id="payment_date" placeholder="dd-mm-yyyy" value="<?php echo  date('d-m-Y');?>"  autocomplete="off" required>
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
        <button type="submit" id="BillCollectionSaveBtn" class="btn btn-primary">  Payment  </button>
        <button onclick="ModalBillCollectionClose()" type="button" class="btn btn-danger" data-dismiss="modal">  <i class="far fa-window-close"></i></button>
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
<script src="{{ asset('public/js/bill.js')}}"></script>
@endsection