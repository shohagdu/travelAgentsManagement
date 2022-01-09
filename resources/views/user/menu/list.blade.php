@extends('layouts.master')
@section('title', 'Acl Menu List')
@section('css')
 <!-- DataTables -->
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
        <h5 class="card-title mb-0 lefttButtonText" > Menu  List</h5>
        <a href="{{ url('acl-menu/create')}}" class="btn btn-success btn-sm text-white rightButton">
          <i class="mdi mdi-plus-box"></i> Add Menu </a>
  
       <table id="example" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> # </th>
                <th> Title </th>
                <th> Link </th>
                <th> Status </th>
                <th> Action</th>
            </tr>
       
        </thead>
        @php $i=1;  @endphp    
            @foreach($menu_info as $item)
                    <tr>
                        <td>{{ $i++}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->link}}</td>
                        <td>
                            @if($item->is_active == 1)
                               <span class="label label-info"> Active </span>             
                            @elseif($item->is_active == 2)
                                <span class="label label-warning"> Inactive </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('menu.edit', $item->id)}}" class="btn btn-primary btn-xs"> <i class="glyphicon glyphicon-pencil"></i> Edit </a> &nbsp; &nbsp; 
                            <a onclick="return confirm('Are you sure you want to delete?')" href="{{ route('menu.delete', $item->id)}}" class="btn btn-danger btn-xs "> <i class="glyphicon glyphicon-trash"></i> Delete</a>
                        </td>
                    </tr>
            @endforeach
    
   </table>   
   </div> 
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