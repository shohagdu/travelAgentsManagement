@extends('layouts.master')
@section('title', 'Bank Account List')
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
        <h5 class="card-title mb-0 lefttButtonText">Bank Account List</h5>
        <a href="{{ route('bank-create')}}" class="btn btn-success btn-sm text-white rightButton">
          <i class="mdi mdi-plus-box"></i> Add Account  </a>
      </div>
      <table id="zero_config" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Bank Name</th>
            <th scope="col">Branch Name</th>
            <th scope="col">Account No</th>
            <th scope="col">Routing Number</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($bank_data as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td> {{$item->name}}</td>
            <td> {{$item->branch_name}}</td>
            <td> {{$item->account_no}}</td>
            <td> {{$item->routing_number}}</td>
            <td> @if($item->type == 1) Cash @else Bank @endif</td>
            <td> <a href="{{ route('bank-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a onclick="return confirm('Are you sure you want to delete?')" href="{{ route('bank-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
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
@section('js')
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('js/global.js')}}"></script>
@endsection