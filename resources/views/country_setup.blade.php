@extends('layouts.master')
@section('title', 'Country Setup')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Country Setup </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                <input type="text" name="name" id="name" class="form-control"  placeholder="Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Country Code</label>
                <div class="col-sm-4">
                    <input type="text" name="country_code" id="country_code" class="form-control"  placeholder="Country Code">
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