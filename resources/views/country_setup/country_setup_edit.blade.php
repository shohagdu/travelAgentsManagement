@extends('layouts.master')
@section('title', 'Country Setup Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('country-setup-update', $country_data->id)}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('country-setup-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              Country Setup List </a>
            <h4 class="card-title"> Country Setup Update </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  value="{{ $country_data->name}}" required>
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Country Code</label>
                <div class="col-sm-4">
                    <input type="text" name="country_code" id="country_code" class="form-control @error('country_code') is-invalid @enderror" value="{{ $country_data->country_code}}">
                    @error('country_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                  </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary SubmitBtnLeft">
                Update
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection