@extends('layouts.master')
@section('title', 'Airline Setup')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        
        <form class="form-horizontal" method="POST" action="{{ route('airline-setup-save')}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('airline-setup-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              Airline Setup List </a>
            <h4 class="card-title "> Airline Setup </h4>
            <div class="form-group row">
                <label for="airline_title" class="col-sm-2 text-end control-label col-form-label"> Airline Title</label>
                <div class="col-sm-10">
                  <input type="text" name="airline_title" id="airline_title" class="form-control @error('airline_title') is-invalid @enderror"  placeholder="Airline Title" required>
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
                    <input type="text" name="country_name" id="country_name" class="form-control @error('country_name') is-invalid @enderror"  placeholder="Country Name">
                </div>
                @error('country_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror 
                <label for="fare" class="col-sm-2 text-end control-label col-form-label">Fare</label>
                <div class="col-sm-4">
                    <input type="text" name="fare"  id="fare" class="form-control"  required  placeholder="Fare">
                </div>
            </div>
            <div class="form-group row">
                <label for="commission" class="col-sm-2 text-end control-label col-form-label">Commission(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="commission"  id="commission" class="form-control"  required  placeholder="0.00">
                </div>
                <label for="add" class="col-sm-2 text-end control-label col-form-label"> Add(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="add" id="add"  class="form-control" required placeholder="0.00">
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