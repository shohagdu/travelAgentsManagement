@extends('layouts.master')
@section('title', 'Sale Category')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('sale-category-save')}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('sale-category-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Sale Category List </a>
            <h4 class="card-title"> Sale Category </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Title</label>
                <div class="col-sm-4">
                   <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"  placeholder="Title">
                   @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Type</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value="">  Select</option>
                        <option value="1"> Flights </option>
                        <option value="2"> Hotels </option>
                        <option value="3"> Transfers </option>
                        <option value="4"> Activities </option>
                        <option value="5"> Holidays</option>
                        <option value="6"> Visa </option>
                        <option value="7"> Others </option>
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