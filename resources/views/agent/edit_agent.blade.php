@extends('layouts.master')
@section('title', 'Update Agent')
@section('css')
<link rel="stylesheet" type="text/css"href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>    
@endsection
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }} alert-dismissible fade show" role="alert">
      {{ session('flash.message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('agent-update', $agent_data->id )}}">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Agent Record Update</h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  value="{{ $agent_data->name}}"  placeholder="Name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
                <label for="mobile" class="col-sm-2 text-end control-label col-form-label">Mobile</label>
                <div class="col-sm-4">
                    <input type="text" name="mobile"  id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ $agent_data->mobile}}" required  placeholder="Mobile">
                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 text-end control-label col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email"  class="form-control" required value="{{ $agent_data->email}}"placeholder="Email">
                </div>
                <label for="office_phone" class="col-sm-2 text-end control-label col-form-label"> Office Phone</label>
                <div class="col-sm-4">
                    <input type="text" name="office_phone"  id="office_phone" class="form-control" value="{{ $agent_data->office_phone}}" required  placeholder="Office Phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="company_name" class="col-sm-2 text-end control-label col-form-label"> Company Name</label>
                <div class="col-sm-10">
                 <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ $agent_data->company_name}}"  placeholder="Company Name">
                @error('company_name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
                 @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 text-end control-label col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" id="address" class="form-control"placeholder="Address">{{ $agent_data->address}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="currency" class="col-sm-2 text-end control-label col-form-label"> Country</label>
                <div class="col-sm-4">
                    <select name="country" id="country"   onchange="getCity(this.value, 'city_id')" class="select2 form-select shadow-none ">
                    <option value=""> Select </option>
                    @foreach ($country as $item )
                        <option value="{{$item->id}}" @if($agent_data->country == $item->id) echo selected @endif> {{$item->name}} </option>
                    @endforeach   
                    </select>
                </div>
                <label for="city" class="col-sm-2 text-end control-label col-form-label"> City</label>
                <div class="col-sm-4">
                    <select name="city" id="city" class="select2 form-select shadow-none">
                        <option value=""> Select </option>
                        @foreach ($state as $item )
                        <option value="{{$item->id}}" @if($agent_data->city == $item->id) echo selected @endif> {{$item->name}} </option>
                        @endforeach  
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="zip_code" class="col-sm-2 text-end control-label col-form-label">Zip Code</label>
                <div class="col-sm-4">
                    <input type="text" name="zip_code"  id="zip_code" class="form-control"  value="{{ $agent_data->zip_code}}" required  placeholder="Zip Code">
                </div>
                <label for="office_phone" class="col-sm-2 text-end control-label col-form-label">Opening Balance</label>
                <div class="col-sm-4">
                    <input type="text" name="opening_balance" id="opening_balance" value="{{ $agent_data->opening_balance}}" class="form-control" required placeholder="0.00">
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
@section('js')
<script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset('public/js/global.js')}}"></script>
@endsection