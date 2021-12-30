@extends('layouts.master')
@section('title', 'Update User')
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-8">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('user-update', $user_info->id ) }}" enctype="multipart/form-data">
                @csrf
          <div class="card-body">
            <h4 class="card-title">Update User</h4>
            <div class="form-group row">
              <label
                for="fname"
                class="col-sm-3 text-end control-label col-form-label"
                > Name</label>
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
                for="mobile"
                class="col-sm-3 text-end control-label col-form-label"
                >Mobile</label>
              <div class="col-sm-9">
                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $user_info->mobile }}" required autocomplete="off" >
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
                for="picture"
                class="col-sm-3 text-end control-label col-form-label"
                >Picture </label>
              <div class="col-sm-9">
                <input id="picture" type="file" class="form-control" name="picture" value="{{ old('picture') }}">
                <input name="old_picture" type="hidden" value="{{ $user_info->picture}}">
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