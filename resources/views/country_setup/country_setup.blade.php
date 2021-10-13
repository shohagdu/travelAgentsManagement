@extends('layouts.master')
@section('title', 'Country Setup')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('country-setup-save')}}">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Country Setup </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  placeholder="Name" required>
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
                    <input type="text" name="country_code" id="country_code" class="form-control @error('country_code') is-invalid @enderror"  placeholder="Country Code">
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
                Save
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection