@extends('layouts.master')
@section('title', 'Change Password')
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-8">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('change_password_stote') }}">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Change Password</h4>

            <div class="form-group row">
              <label
                for="lname"
                class="col-sm-4 text-end control-label col-form-label"
                >Old Password</label
              >
              <div class="col-sm-8">
                <input id="old_password" type="password" class="form-control" name="old_password" required placeholder="Old Password">
              </div>
            </div>

            <div class="form-group row">
              <label
                for="lname"
                class="col-sm-4 text-end control-label col-form-label"
                >New Password</label
              >
              <div class="col-sm-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label
                for="password"
                class="col-sm-4 text-end control-label col-form-label"
                >Confirm New Password</label
              >
              <div class="col-sm-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-success text-white SubmitBtn">
                Change Password 
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection