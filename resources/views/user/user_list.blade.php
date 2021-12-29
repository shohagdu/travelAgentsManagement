@extends('layouts.master')
@section('title', 'User List')
@section('css')
<link href="{{ asset('public/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet"/>    
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
      </div>
      <table id="zero_config" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Name</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
            <th scope="col">Picture</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($user_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->name}}</td>
            <td>{{$item->mobile}}</td>
            <td>{{$item->email}}</td>
            <td>
              @if($item->picture != NULL)
                <img width="50px" height="40px" src="{{ asset('public/assets/images/users')}}/{{ $item->picture}}">
              @else
              <img width="50px" height="40px"  src="{{ asset('public/assets/images/users/profile.jpg')}}">
              @endif
            </td>
            <td> <a href="{{ route('user-edit', Crypt::encrypt($item->id))}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('user-delete',  $item->id)}}" class="btn btn-danger btn-sm text-white">
              <span class="mdi mdi-delete-circle"></span>  Delete
            </a>
          </td>
          </tr>
          @endforeach
        </tbody>
      </table><br><br>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection