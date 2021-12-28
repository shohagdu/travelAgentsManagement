@extends('layouts.master')
@section('title', 'Today Sale Balance')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/customs.css')}}">
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-0 lefttButtonText" > Agent Due  Statement</h5>
      </div>
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Mobile</th>
            <th scope="col">Address</th>
            <th scope="col">Due Amount </th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0; @endphp
        @foreach ($due_list_view as $item )
            
        <tr>
          <td>{{ $i++}}</td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> 0.00 </td>
        </tr>
        @endforeach
        <tr>
          <th colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
          <th>  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection