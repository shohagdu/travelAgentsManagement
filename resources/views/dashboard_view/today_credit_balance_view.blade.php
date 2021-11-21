@extends('layouts.master')
@section('title', 'Today Credit Balance')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/customs.css')}}">
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-0 lefttButtonText" > Today Credit Balance</h5>
      </div>
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Remarks</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0; @endphp
        @foreach ($today_credit_balance as $item )
            
        <tr>
          <td>{{ $i++}}</td>
          <td>{{ $item->agent_name}}</td>
          <td>{{ $item->remarks}}</td>
          <td>{{ date('d-m-Y', strtotime($item->trans_date))}}</td>
          <td>@php  echo $item->credit_amount; $total_amount += $item->credit_amount;  @endphp</td>
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