@extends('layouts.master')
@section('title', 'Bank Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('bank-update', $bank_info->id)}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('bank-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Bank List </a>
            <h4 class="card-title"> Bank Update </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Bank Name</label>
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