@extends('layouts.master')
@section('title', 'Bill Collection')
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
        <h5 class="card-title mb-0 lefttButtonText"> Bill Collection </h5>
        <button class="btn btn-success btn-sm text-white rightButton" onclick="ModalBillCollection()">
          <i class="mdi mdi-plus-box"></i> Add Bill Collection </button>
      </div>
      <table id="zero_config" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Name</th>
            <th scope="col">Amount </th>
            <th scope="col">Action</th>
          </tr>
        </thead>
       
      </table>
    </div>
  </div>
  <!-- Bill  modal -->
<div class="modal fade" id="BillCollectionModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Bill Collection</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="agent_id" class="col-sm-4 text-end control-label col-form-label"> Agent Name</label>
          <div class="col-sm-8">
              <select id="agent_id" name="agent_id" class="form-control @error('agent_id') is-invalid @enderror">
                <option value=""> Select Agent </option>
                @foreach ($agent_info as $item)
                  <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                @endforeach
            </select>
              @error('agent_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror 
          </div>
        </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-4 text-end control-label col-form-label"> Amount </label>
          <div class="col-sm-8">
            <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror"  placeholder="0.00" required>
              @error('amount')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror 
          </div>
        </div>
        <div class="form-group row">
          <label for="payment_method" class="col-sm-4 text-end control-label col-form-label"> Payment Method</label>
          <div class="col-sm-8">
              <select id="payment_method" name="payment_method" onchange="PaymentMethod(this.value)" class="form-control @error('payment_method') is-invalid @enderror">
                <option value=""> Select Payment Method </option>
                <option value="1"> Cash </option> 
                <option value="2"> Bank </option> 
            </select>
              @error('payment_method')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror 
          </div>
        </div>
        <div class="form-group row" id="BankNameId" style="display: none">
          <label for="bank_name" class="col-sm-4 text-end control-label col-form-label"> Bank Name</label>
          <div class="col-sm-8">
              <select id="bank_name" name="bank_name" class="form-control @error('payment_method') is-invalid @enderror">
                <option value=""> Select Bank  </option>
                @foreach ($bank as $item )
                <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row" id="chequeNoId" style="display: none">
          <label for="cheque_no" class="col-sm-4 text-end control-label col-form-label"> Cheque No</label>
          <div class="col-sm-8">
            <input type="text" name="cheque_no" id="cheque_no" class="form-control"  placeholder="Cheque No" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="amount" class="col-sm-4 text-end control-label col-form-label"> Remark </label>
          <div class="col-sm-8">
            <textarea name="remark" id="remark" class="form-control"></textarea> 
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Payment  </button>
      </div>
    </div>
  </div>
</div>

</div>


@endsection
@section('js')
<script>
  function ModalBillCollection(){
    $('#BillCollectionModal').modal('show');
  }
  </script>
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('js/global.js')}}"></script>
@endsection