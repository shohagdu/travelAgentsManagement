@extends('layouts.master')
@section('title', 'Update User')
@section('breadcrumb')

<div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">User</h4>
        <div class="ms-auto text-end">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                Library
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-8">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('user-update', $user_info->id ) }}">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Update User</h4>
            <div class="form-group row">
              <label
                for="fname"
                class="col-sm-3 text-end control-label col-form-label"
                > Name</label
              >
              <div class="col-sm-9">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user_info->name }}" required autocomplete="name" autofocus>

                @error('name')
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
                >Email</label
              >
              <div class="col-sm-9">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user_info->email }}" required autocomplete="email" readonly>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
              </div>
            </div>
            <div class="form-group row">
              <label
                for="lname"
                class="col-sm-3 text-end control-label col-form-label"
                >Password</label
              >
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
                for="email1"
                class="col-sm-3 text-end control-label col-form-label"
                >Confirm Password</label
              >
              <div class="col-sm-9">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-info SubmitBtn">
                Update
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection