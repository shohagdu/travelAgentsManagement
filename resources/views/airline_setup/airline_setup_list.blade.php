@extends('layouts.master')
@section('title', 'Alinene Setup List')
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
        <h5 class="card-title mb-0">Airline Setup List</h5>
      </div>
      <table border="1" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Airline Title</th>
            <th scope="col">Country Name</th>
            <th scope="col">Fare</th>
            <th scope="col">Commission(%)</th>
            <th scope="col">Add(%)</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($airline_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->airline_title}}</td>
            <td> {{$item->country_name}} </td>
            <td>{{$item->fare}}</td>
            <td>{{$item->commission}}</td>
            <td>{{$item->add}}</td>
            <td> <a href="{{ route('airline-setup-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('airline-setup-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
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