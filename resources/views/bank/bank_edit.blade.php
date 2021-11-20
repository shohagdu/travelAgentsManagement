@extends('layouts.master')
@section('title', 'Bank Account Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('bank-update', $bank_info->id)}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('bank-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Account List </a>
            <h4 class="card-title"> Account Update </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Account Name</label>
                <div class="col-sm-4">
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$bank_info->name}}" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
              <label for="branch_name" class="col-sm-2 text-end control-label col-form-label"> Branch Name</label>
              <div class="col-sm-4">
                 <input type="text" name="branch_name" id="branch_name" class="form-control"  value="{{$bank_info->branch_name}}"placeholder="Branch Name">
              </div> 
            <div class="form-group row">
                <label for="account_no" class="col-sm-2 text-end control-label col-form-label"> Account No</label>
                <div class="col-sm-4">
                    <input type="text" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror"  value="{{$bank_info->account_no}}">
                    @error('account_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                  </div>
            </div>
            <div class="form-group row">
              <label for="routing_number" class="col-sm-2 text-end control-label col-form-label"> Routing Number</label>
              <div class="col-sm-4">
                 <input type="text" name="routing_number" id="routing_number" class="form-control" value="{{$bank_info->routing_number}}"  placeholder="Routing Number">
              </div>
            </div>
            <div class="form-group row">
              <label for="opening_balance" class="col-sm-2 text-end control-label col-form-label"> Opening Balance</label>
              <div class="col-sm-4">
                  <input type="text" name="opening_balance" id="opening_balance" class="form-control"  placeholder=" Opening Balance"  value="{{  $bank_info->opening_balance}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="type" class="col-sm-2 text-end control-label col-form-label"> Type </label>
              <div class="col-sm-4">
                  <select name="type" id="type" class="form-control" >
                    <option  value=""> Select</option>
                    <option value="1" @if($bank_info->type == 1) selected @endif> Cash </option>
                    <option value="2" @if($bank_info->type == 2) selected @endif > Bank </option>
                  </select>
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