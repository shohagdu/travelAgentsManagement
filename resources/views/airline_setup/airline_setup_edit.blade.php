@extends('layouts.master')
@section('title', 'Update Airline Setup')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('airline-setup-update',$airline_info->id)}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('airline-setup-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"> </i> Airline Setup List </a>
            <h4 class="card-title "> Update Airline Setup </h4>
            <div class="form-group row">
                <label for="airline_name" class="col-sm-2 text-end control-label col-form-label"> Airline Name</label>
                <div class="col-sm-10">
                  <input type="text" name="airline_name" id="airline_name" class="form-control @error('airline_name') is-invalid @enderror"  placeholder="Airline Name" value="{{$airline_info->airline_name}}" required>
                </div>
                @error('airline_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
            </div>
            <div class="form-group row">
                <label for="category" class="col-sm-2 text-end control-label col-form-label"> Category</label>
                <div class="col-sm-4">
                  <select name="category" id="category" class="form-control @error('category') is-invalid @enderror"> 
                    <option value=""> Select</option>
                    <option value="1" @if($airline_info->category==1) selected @endif> International</option>
                    <option value="2" @if($airline_info->category==2) selected @endif> Domestic</option>
                  </select>
                </div>
                @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror 
                <label for="fare" class="col-sm-2 text-end control-label col-form-label"> Fare</label>
                <div class="col-sm-4">
                    <input type="text" name="fare" id="fare" onchange="AirlineTotalFare()"  class="form-control" value="{{$airline_info->fare}}" required placeholder="0.00">
                </div>
            </div>
            <div class="form-group row">
              <label for="tax_amount" class="col-sm-2 text-end control-label col-form-label">Tax Amount </label>
              <div class="col-sm-4">
                  <input type="text" name="tax_amount"  id="tax_amount" onchange="AirlineTotalFare()" class="form-control"  required value="{{$airline_info->tax_amount}}"  placeholder="Tax Amount">
              </div>
              <label for="total_fare" class="col-sm-2 text-end control-label col-form-label">Total Fare</label>
              <div class="col-sm-4">
                  <input type="text" name="total_fare"  id="total_fare" class="form-control"  required  value="{{$airline_info->total_fare}}"  placeholder="0.00">
              </div>
            </div>
            <div class="form-group row">
                <label for="commission" class="col-sm-2 text-end control-label col-form-label">Commission(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="commission"  id="commission" onchange="AirlineTotalFare()" class="form-control" value="{{$airline_info->commission}}"  required  placeholder="0.00">
                </div>
                <label for="commission_amount" class="col-sm-2 text-end control-label col-form-label">Commission Amount</label>
                <div class="col-sm-4">
                    <input type="text" name="commission_amount"  id="commission_amount" class="form-control"  required value="{{$airline_info->commission_amount}}"  placeholder="0.00">
                </div>
            </div>
            <div class="form-group row">
              <label for="ait" class="col-sm-2 text-end control-label col-form-label"> AIT(%)</label>
              <div class="col-sm-4">
                  <input type="text" name="ait" id="ait"  onchange="AirlineTotalFare()" class="form-control" value="{{$airline_info->ait}}"  required placeholder="0.00">
              </div>
              <label for="ait_amount" class="col-sm-2 text-end control-label col-form-label"> AIT Amount</label>
              <div class="col-sm-4">
                  <input type="text" name="ait_amount" id="ait_amount"  class="form-control" required value="{{$airline_info->ait_amount}}"  placeholder="0.00">
              </div>
            </div>
  
          <div class="form-group row">
            <label for="add" class="col-sm-2 text-end control-label col-form-label"> Add </label>
            <div class="col-sm-4">
                <input type="text" name="add" id="add"  onchange="AirlineTotalFare()" class="form-control" required value="{{$airline_info->add}}"  placeholder="0.00">
            </div>
            <label for="invoice_total" class="col-sm-2 text-end control-label col-form-label"> Invoice Total</label>
            <div class="col-sm-4">
                <input type="text" name="invoice_total" id="invoice_total"  class="form-control" required value="{{$airline_info->invoice_total}}"  placeholder="0.00">
            </div>
          </div>
        </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-info SubmitBtnLeft">
                Update
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('js')
    <script src="{{ asset('public/js/global.js')}}"></script>
@endsection

