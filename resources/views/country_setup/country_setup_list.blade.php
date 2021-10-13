@extends('layouts.master')
@section('title', 'Country Setup List')
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
        <h5 class="card-title mb-0">Country Setup List</h5>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Name</th>
            <th scope="col">Country Code</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($country_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td> {{$item->name}}</td>
            <td> {{$item->country_code}}</td>
            <td> <a href="{{ route('country-setup-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('country-setup-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
              <span class="mdi mdi-delete-circle"></span>  Delete
            </a>
          </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection