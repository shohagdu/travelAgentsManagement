@extends('layouts.master')
@section('title', 'Add User')
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-8">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('user-register') }}" enctype="multipart/form-data">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Add User</h4>
            <div class="form-group row">
              <label
                for="fname"
                class="col-sm-3 text-end control-label col-form-label"
                > Name</label>
              <div class="col-sm-9">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label
                for="mobile"
                class="col-sm-3 text-end control-label col-form-label"
                >Mobile</label>
              <div class="col-sm-9">
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('name') }}" required autocomplete="off" placeholder="Mobile">
                    @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
            </div>
            <div class="form-group row">
              <label
                for="email"
                class="col-sm-3 text-end control-label col-form-label"
                >Email</label>
              <div class="col-sm-9">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
            </div>
            <div class="form-group row">
              <label
                for="picture"
                class="col-sm-3 text-end control-label col-form-label"
                >Picture </label>
              <div class="col-sm-9">
                <input id="picture" type="file" class="form-control" name="picture" value="{{ old('picture') }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="is_active" class="col-md-3 col-form-label text-end ">{{ __('Role') }}</label>
              <div class="col-md-9">
                  <select  class="form-control @error('role_id') is-invalid @enderror" name="role_id" value="{{ old('role_id') }}" >
                      <option value="">Select</option>
                      @foreach($role_info as $item)
                          <option value="{{$item->id}}"> {{$item->role_name}} </option>
                      @endforeach
                  </select>
                  @error('role_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>
            <div class="form-group row">
              <label
                for="password"
                class="col-sm-3 text-end control-label col-form-label"
                >Password</label>
              <div class="col-sm-9">
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
                for="password_confirmation"
                class="col-sm-3 text-end control-label col-form-label"
                >Confirm Password</label>
              <div class="col-sm-9">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary SubmitBtn">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection