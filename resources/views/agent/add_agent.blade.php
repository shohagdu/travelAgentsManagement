@extends('layouts.master')
@section('title', 'Add Agent')
@section('css')
<link rel="stylesheet" type="text/css"href="{{ asset('assets/libs/select2/dist/css/select2.min.css')}}"/>    
@endsection
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Agent Record</h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                    <input type="text" name="name" id="name" class="form-control"  placeholder="Name">
                </div>
                <label for="mobile" class="col-sm-2 text-end control-label col-form-label">Mobile</label>
                <div class="col-sm-4">
                    <input type="text" name="mobile"  id="mobile" class="form-control"  required  placeholder="Mobile">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 text-end control-label col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email"  class="form-control" required placeholder="Email">
                </div>
                <label for="office_phone" class="col-sm-2 text-end control-label col-form-label"> Office Phone</label>
                <div class="col-sm-4">
                    <input type="text" name="office_phone"  id="office_phone" class="form-control"  required  placeholder="Office Phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="company_name" class="col-sm-2 text-end control-label col-form-label"> Company Name</label>
                <div class="col-sm-10">
                <input type="text" name="company_name" id="company_name" class="form-control"  placeholder="Company Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 text-end control-label col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" id="address" class="form-control"  placeholder="Address"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="currency" class="col-sm-2 text-end control-label col-form-label"> Country</label>
                <div class="col-sm-4">
                    <select name="country_id" id="country_id"   onchange="getCity(this.value, 'city_id')" class="select2 form-select shadow-none ">
                    <option value=""> Select </option>
                    @foreach ($country as $item )
                        <option value="{{$item->id}}"> {{$item->name}} </option>
                    @endforeach   
                    </select>
                </div>
                <label for="city" class="col-sm-2 text-end control-label col-form-label"> City</label>
                <div class="col-sm-4">
                    <select name="city_id" id="city_id" class="select2 form-select shadow-none">
                        <option value=""> Select </option>
                        @foreach ($state as $item )
                        <option value="{{$item->id}}"> {{$item->name}} </option>
                        @endforeach  
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="zip_code" class="col-sm-2 text-end control-label col-form-label">Zip Code</label>
                <div class="col-sm-4">
                    <input type="text" name="zip_code"  id="zip_code" class="form-control"  required  placeholder="Zip Code">
                </div>
                <label for="office_phone" class="col-sm-2 text-end control-label col-form-label">Opening Balance</label>
                <div class="col-sm-4">
                    <input type="text" name="office_phone" id="office_phone"  class="form-control" required placeholder="0.00">
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
@section('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset('js/global.js')}}"></script>
@endsection