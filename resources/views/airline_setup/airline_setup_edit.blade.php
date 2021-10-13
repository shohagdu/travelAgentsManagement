@extends('layouts.master')
@section('title', 'Airline Setup Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('airline-setup-update', $airline_info->id)}}">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Airline Setup Update</h4>
            <div class="form-group row">
                <label for="airline_title" class="col-sm-2 text-end control-label col-form-label"> Airline Title</label>
                <div class="col-sm-10">
                  <input type="text" name="airline_title" id="airline_title" class="form-control @error('airline_title') is-invalid @enderror"  value="{{ $airline_info->airline_title}}" required>
                </div>
                @error('airline_title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror 
            </div>
            <div class="form-group row">
                <label for="country_name" class="col-sm-2 text-end control-label col-form-label"> Country Name</label>
                <div class="col-sm-4">
                    <input type="text" name="country_name" id="country_name" class="form-control @error('country_name') is-invalid @enderror" value="{{ $airline_info->country_name}}">
                </div>
                @error('country_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror 
                <label for="fare" class="col-sm-2 text-end control-label col-form-label">Fare</label>
                <div class="col-sm-4">
                    <input type="text" name="fare"  id="fare" class="form-control"  required  value="{{ $airline_info->fare}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="commission" class="col-sm-2 text-end control-label col-form-label">Commission(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="commission"  id="commission" class="form-control"  required  value="{{ $airline_info->commission}}">
                </div>
                <label for="add" class="col-sm-2 text-end control-label col-form-label"> Add(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="add" id="add"  class="form-control" required value="{{ $airline_info->add}}">
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