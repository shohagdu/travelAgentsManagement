@extends('layouts.master')
@section('title', 'Sale Category List')
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
        <h5 class="card-title mb-0">Sale Category List</h5>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Title</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach ($category_info as $item )
          <tr>
            <th scope="row">{{ $i++}}</th>
            <td>{{$item->title}}</td>
            <td>
            @php
                if ($item->type == 1) {
                  echo "Flights";
                }elseif ($item->type ==2 ) {
                  echo "Hotels";
                }elseif ($item->type ==3 ) {
                  echo "Transfers";
                }elseif ($item->type ==4 ) {
                  echo "Activities";
                }elseif ($item->type ==5 ) {
                  echo "Holidays";
                }elseif ($item->type ==6 ) {
                  echo "Visa";
                }elseif ($item->type ==7 ) {
                  echo "Others";
                }else{
                  echo "";
                }
            @endphp  
            </td>
            <td> <a href="{{ route('sale-category-edit',$item->id)}}" class="btn btn-cyan btn-sm text-white"> <span class="mdi mdi-pencil-box-outline"></span>
              Edit
            </a> 
            <a   onclick="return confirm('Are you sure you want to delete?')" href="{{ route('sale-category-delete',$item->id)}}" class="btn btn-danger btn-sm text-white">
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