@extends('layouts.master')
@section('title', 'Alinene Setup List')
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
        <h5 class="card-title mb-0 lefttButtonText" >Add Airline Setup</h5>
        <a href="{{ route('airline-setup')}}" class="btn btn-success btn-sm text-white rightButton">
          Add Airline Setup </a>
      </div>
      <table id="zero_config" border="1" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Airline Name</th>
            <th scope="col">Category</th>
            <th scope="col">Fare</th>
            <th scope="col">Tax</th>
            <th scope="col">Total Fare</th>
            <th scope="col">Commission</th>
            <th scope="col">AIT</th>
            <th scope="col">Add </th>
            <th scope="col">Invoice Total </th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($airline_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->airline_name}}</td>
            <td>
              @if($item->category == 1)
              International
              @elseif($item->category ==1)
              Domestic
              @endif
            </td>
            <td>{{$item->fare}}</td>
            <td>{{$item->tax_amount}}</td>
            <td>{{$item->fare+$item->tax_amount}}</td>
            <td>{{$item->commission_amount}}</td>
            <td>{{$item->ait_amount}}</td>
            <td>{{$item->add}}</td>
            <td>{{$item->invoice_total}}</td>
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
@section('js')
<script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('js/global.js')}}"></script>
@endsection