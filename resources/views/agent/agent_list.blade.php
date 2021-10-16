@extends('layouts.master')
@section('title', 'Agent Record List')
@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet"/>    
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
        <h5 class="card-title mb-0">Agent Record List</h5>
      </div>

      <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">Sl</th>
              <th scope="col">Name</th>
              <th scope="col">Mobile</th>
              <th scope="col">Email</th>
              <th scope="col">Company Name</th>
              <th scope="col">Country</th>
              <th scope="col">City</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 1; @endphp
            @foreach ($agent_info as $item )
            <tr>
              <th scope="row">{{ $i++}}</th>
              <td>{{$item->name}}</td>
              <td> {{$item->mobile}} </td>
              <td>{{$item->email}}</td>
              <td>{{$item->company_name}}</td>
              <td>{{$item->country_name}}</td>
              <td>{{$item->city_name}}</td>
              <td> <a href="{{ route('agent-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
                Edit
              </a> 
              <a onclick="return confirm('Are you sure you want to delete?')" href="{{ route('agent-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
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
</div>
@endsection
@section('js')
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('js/global.js')}}"></script>
@endsection