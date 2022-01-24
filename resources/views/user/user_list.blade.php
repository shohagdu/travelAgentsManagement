@extends('layouts.master')
@section('title', 'User List')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/datatable/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    @if (session()->has('flash.message'))
    <div class="alert alert-{{ session('flash.class') }} alert-dismissible fade show" role="alert">
      {{ session('flash.message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
      <div class="card-body">
        <h5 class="card-title ">User List</h5>
      
      <table id="example" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Name</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
            <th scope="col">Picture</th>
            <th scope="col">Role Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($user_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->user_name}}</td>
            <td>{{$item->mobile}}</td>
            <td>{{$item->email}}</td>
            <td>
              @if($item->picture != NULL)
                <img width="50px" height="40px" src="{{ asset('public/assets/images/users')}}/{{ $item->picture}}">
              @else
              <img width="50px" height="40px"  src="{{ asset('public/assets/images/users/profile.jpg')}}">
              @endif
            </td>
            <td>{{$item->role_name}}</td>
            <td> <a href="{{ route('user-edit', Crypt::encrypt($item->UserId))}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('user-delete',  $item->UserId)}}" class="btn btn-danger btn-sm text-white">
              <span class="mdi mdi-delete-circle"></span>  Delete
            </a>
          </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div><br><br>
    </div>
  </div>
</div>
@endsection
@section('js')
 <!-- DataTables  -->
 <script src="{{ asset('public/assets/datatable/js/jquery.dataTables.min.js')}}"></script>
 <script src="{{ asset('public/assets/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
 <script src="{{ asset('public/assets/datatable/js/dataTables.responsive.min.js')}}"></script>
 <script src="{{ asset('public/assets/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection