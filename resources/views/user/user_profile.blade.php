@extends('layouts.master')
@section('title', 'My Profile')
@section('main_content')
<div class="row">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }}">
        {{ session('flash.message') }}
    </div>
    @endif

    <div class="col-md-8">
      <div class="card">
          <div class="card-body">
            <h4 class="card-title"> My Profile </h4>
            <table>
              <tr>
                <td> Name  </td>
                <td>   {{ $user_info->name }} </td>
              </tr>
              <tr>
                <td> Email  </td>
                <td>  {{ $user_info->email }} </td>
              </tr>
            </table>
          </div>
      </div>
    </div>
  </div>
@endsection