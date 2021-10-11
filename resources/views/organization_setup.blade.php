@extends('layouts.master')
@section('title', 'Organization Setup')
@section('css')
<link rel="stylesheet" type="text/css"href="{{ asset('assets/libs/select2/dist/css/select2.min.css')}}"/>    
@endsection
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('user-register') }}">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Organization Setup</h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Organization Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control"  placeholder="Organization Name">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 text-end control-label col-form-label">Address</label>
                <div class="col-sm-10">
                    <textarea name="address" id="address" class="form-control"  placeholder="Address"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="mobile" class="col-sm-2 text-end control-label col-form-label">Mobile</label>
                <div class="col-sm-4">
                    <input type="text" name="mobile"  id="text" class="form-control"  required  placeholder="Mobile">
                </div>
                <label for="email" class="col-sm-2 text-end control-label col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email"  class="form-control" required placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="telephone" class="col-sm-2 text-end control-label col-form-label">Telephone</label>
                <div class="col-sm-4">
                    <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Telephone">
                </div>
                <label for="website_address" class="col-sm-2 text-end control-label col-form-label">Website address</label>
                <div class="col-sm-4">
                    <input type="text" name="website_address" id="website_address" class="form-control" placeholder="Wsebsite address">
                </div>
            </div>
            <div class="form-group row">
                <label for="telephone" class="col-sm-2 text-end control-label col-form-label">Tradelicense No</label>
                <div class="col-sm-4">
                    <input type="text" name="tradelicense_no" id="tradelicense_no" class="form-control" placeholder="Tradelicense No">
                </div>
                <label for="website_address" class="col-sm-2 text-end control-label col-form-label">Vat No</label>
                <div class="col-sm-4">
                    <input type="text" name="vat_no" id="vat_no" class="form-control" placeholder="Vat No">
                </div>
            </div>
            <div class="form-group row">
                <label for="website_address" class="col-sm-2 text-end control-label col-form-label">Tax Amount(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="tax_amount" id="tax_amount" class="form-control" placeholder="Tax Amount">
                </div>
                <label for="per_invoice_deduction_amount" class="col-sm-2 text-end control-label col-form-label"> Deduction Amount	</label>
                <div class="col-sm-4">
                    <input type="text" name="per_invoice_deduction_amount" id="per_invoice_deduction_amount" class="form-control" placeholder="Per Invoice Deduction Amount">
                </div>
            </div>
            <div class="form-group row">
                <label for="ait" class="col-sm-2 text-end control-label col-form-label">AIT(%)</label>
                <div class="col-sm-4">
                    <input type="text" name="ait" id="ait" class="form-control" placeholder="AIT">
                </div>
                <label for="footer_text" class="col-sm-2 text-end control-label col-form-label"> Footer Text</label>
                <div class="col-sm-4">
                    <input type="text" name="footer_text" id="footer_text" class="form-control" placeholder="Footer Text">
                </div>
            </div>
            <div class="form-group row">
                <label for="currency" class="col-sm-2 text-end control-label col-form-label"> Currency</label>
                <div class="col-sm-4">
                    <select name="currency" id="currency" class="select2 form-select shadow-none ">
                        <option value=""> Select </option>
                        @foreach ($currency_list as $key=> $item )
                        <option value="{{ $key}}"> {{$key}} ({{$item}}) </option>
                        @endforeach
                    </select>
                </div>
                <label for="footer_text" class="col-sm-2 text-end control-label col-form-label"> Time Zone</label>
                <div class="col-sm-4">
                    <select name="time_zone" id="time_zone" class="select2 form-select shadow-none">
                        <option value=""> Select </option>
                        @foreach ($time_zone_list as $key=>  $item)
                        <option value="{{ $item}}"> {{$key}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-2 text-end control-label col-form-label">Logo</label>
                <div class="col-sm-4">
                    <input type="file" name="logo" id="logo" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_logo_preview" src="assets/images/users/1.jpg" class="organization_logo"/>
                    </div>
                </div>
                <label for="templete_logo" class="col-sm-2 text-end control-label col-form-label"> Templete logo</label>
                <div class="col-sm-4">
                    <input type="file" name="templete_logo" id="templete_logo" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_templete_logo_preview" src="assets/images/users/1.jpg" class="organization_templete_logo_preview"/>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="logo" class="col-sm-2 text-end control-label col-form-label">Favicon</label>
                <div class="col-sm-4">
                    <input type="file" name="favicon" id="favicon" class="form-control">
                    <div class="organization_preview_img">
                        <img id="organization_favicon_preview" src="assets/images/users/1.jpg" class="organization_favicon_preview"/>
                    </div>
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