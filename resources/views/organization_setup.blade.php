@extends('layouts.master')
@section('title', 'Company Configuration')
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
        <form class="form-horizontal" method="POST"   action="{{ route('organization-setup-save') }}" enctype="multipart/form-data">
                @csrf

          <div class="card-body">
            <h4 class="card-title">Company  Configuration</h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Company Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"  value="{{ !empty($organization_info->name) ? $organization_info->name : ''}}" placeholder="Organization Name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
          
            <div class="form-group row">
                <label for="address" class="col-sm-2 text-end control-label col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"  placeholder="Address">{{ !empty($organization_info->address) ? $organization_info->address : ''}}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="mobile" class="col-sm-2 text-end control-label col-form-label">Mobile</label>
                <div class="col-sm-4">
                    <input type="text" name="mobile"  id="text" class="form-control @error('mobile') is-invalid @enderror" value="{{ !empty($organization_info->mobile) ? $organization_info->mobile : ''}}" required  placeholder="Mobile">
                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
                <label for="email" class="col-sm-2 text-end control-label col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email"  class="form-control" value="{{ !empty($organization_info->email) ? $organization_info->email : ''}}"  placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="telephone" class="col-sm-2 text-end control-label col-form-label">Telephone</label>
                <div class="col-sm-4">
                    <input type="text" name="telephone" id="telephone" class="form-control"value="{{ !empty($organization_info->telephone) ? $organization_info->telephone : ''}} " placeholder="Telephone">
                </div>
                <label for="website_address" class="col-sm-2 text-end control-label col-form-label">Website address</label>
                <div class="col-sm-4">
                    <input type="text" name="website_address" id="website_address" class="form-control" value="{{ !empty($organization_info->website_address) ? $organization_info->website_address : ''}} " placeholder="Wsebsite address">
                </div>
            </div>
            <div class="form-group row">
                <label for="telephone" class="col-sm-2 text-end control-label col-form-label">Tradelicense No</label>
                <div class="col-sm-4">
                    <input type="text" name="tradelicense_no" id="tradelicense_no" class="form-control" value="{{ !empty($organization_info->tradelicense_no) ? $organization_info->tradelicense_no : ''}}" placeholder="Tradelicense No">
                </div>
                <label for="footer_text" class="col-sm-2 text-end control-label col-form-label"> Footer Text</label>
                <div class="col-sm-4">
                    <input type="text" name="footer_text" id="footer_text" class="form-control" value="{{ !empty($organization_info->footer_text) ? $organization_info->footer_text : ''}}" placeholder="Footer Text">
                </div>
            </div>
            <div class="form-group row">
                <label for="currency" class="col-sm-2 text-end control-label col-form-label"> Currency</label>
                <div class="col-sm-4">
                    <select name="currency" id="currency" class="select2 form-select shadow-none ">
                        <option value=""> Select </option>
                        @foreach ($currency_list as $key=> $item )
                        <option value="{{ $key}}" @if(!empty($organization_info->currency))
                            @if($organization_info->currency == $key) echo Selected @endif
                        @endif> {{$key}} ({{$item}}) </option>
                        @endforeach
                    </select>
                </div>
                <label for="footer_text" class="col-sm-2 text-end control-label col-form-label"> Time Zone</label>
                <div class="col-sm-4">
                    <select name="time_zone" id="time_zone" class="select2 form-select shadow-none">
                        <option value=""> Select </option>
                        @foreach ($time_zone_list as $key=>  $item)
                        <option value="{{ $item}}"  @if(!empty($organization_info->time_zone)) @if($organization_info->time_zone == $item) echo Selected @endif @endif> {{$key}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-2 text-end control-label col-form-label">Logo</label>
                <div class="col-sm-4">
                    <input type="file" name="logo" id="logo" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_logo_preview" src="{{ asset('public/assets/images')}}/{{ !empty($organization_info->logo) ? $organization_info->logo : 'logo.png'}}" class="organization_logo"/>
                        <input type="hidden" name="pre_logo" id="pre_logo" value="{{ !empty($organization_info->logo) ? $organization_info->logo : 'logo.png'}}" > 
                    </div>
                </div> 
                <label for="templete_logo" class="col-sm-2 text-end control-label col-form-label"> Templete logo</label>
                <div class="col-sm-4">
                    <input type="file" name="templete_logo" id="templete_logo" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_templete_logo_preview" src="{{ asset('public/assets/images')}}/{{ !empty($organization_info->templete_logo) ? $organization_info->templete_logo : 'logo-text.png'}}"class="organization_templete_logo_preview"/>
                        <input type="hidden" name="pre_templete_logo" id="pre_templete_logo" value="{{ !empty($organization_info->templete_logo) ? $organization_info->templete_logo : 'logo-text.png'}}" > 
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-2 text-end control-label col-form-label">Favicon</label>
                <div class="col-sm-4">
                    <input type="file" name="favicon" id="favicon" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_favicon_preview" src="{{ asset('public/assets/images')}}/{{ !empty($organization_info->favicon) ? $organization_info->favicon : 'favicon.png'}}"class="organization_favicon_preview"/>
                        <input type="hidden" name="pre_favicon" id="pre_favicon" value="{{ !empty($organization_info->favicon) ? $organization_info->favicon : 'favicon.png'}}" > 
                    </div>
                </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary ">
                            Save
                          </button>
                    </div>
                </div>
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