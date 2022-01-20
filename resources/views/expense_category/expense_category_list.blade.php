@extends('layouts.master')
@section('title', 'Expense Category List')
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
        <h5 class="lefttButtonText" > Expense Category List</h5>
        <a href="{{ route('expense-category')}}" class="btn btn-success btn-sm text-white rightButton">
          <i class="mdi mdi-plus-box"></i> Expense Sale Category </a>
   
      <table id="zero_config" class="table table-bordered mt-1">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($category_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->title}}</td>
           
            <td> <a href="{{ route('expense-category-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('expense-category-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
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
<script src="{{ asset('public/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection