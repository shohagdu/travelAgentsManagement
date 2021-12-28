@extends('layouts.master')
@section('title', 'My Profile')
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-6">
      <div class="card">
          <div class="card-body">
            <h4 class="card-title"> My Profile </h4>

            <div class="row">
              <div class="col-md-8">
                <h3> Name : {{ $user_info->name }}  </h4>
                <h5> Email : {{ $user_info->email }}  </h5>
              </div>
              <div class="col-md-3">
                @if($user_info->picture != NULL)
                  <img width="100px" height="90px" src="{{ asset('public/assets/images/users')}}/{{ $user_info->picture}}">
                @else
                  <img width="100px" height="90px"  src="{{ asset('public/assets/images/users/profile.jpg')}}">
                @endif
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection