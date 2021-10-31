@extends('layouts.master')
@section('title', 'Account Create')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('bank-save')}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('bank-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Account List </a>
            <h4 class="card-title"> Account Create </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Account Name</label>
                <div class="col-sm-4">
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Account Name" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="account_no" class="col-sm-2 text-end control-label col-form-label"> Account No</label>
                <div class="col-sm-4">
                   <input type="text" name="account_no" id="account_no" class="form-control @error('account_no') is-invalid @enderror"  placeholder="Account No">
                    @error('account_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
              <label for="opening_balance" class="col-sm-2 text-end control-label col-form-label"> Opening Balance</label>
              <div class="col-sm-4">
                  <input type="text" name="opening_balance" id="opening_balance" class="form-control"  placeholder=" Opening Balance">
              </div>
            </div>
            <div class="form-group row">
              <label for="type" class="col-sm-2 text-end control-label col-form-label"> Type</label>
              <div class="col-sm-4">
                  <select name="type" id="type" class="form-control" >
                    <option  value=""> Select</option>
                    <option value="1"> Cash </option>
                    <option value="2"> Bank </option>
                  </select>
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary SubmitBtnLeft">
                Save
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection