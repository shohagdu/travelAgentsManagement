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
        <h5 class="card-title mb-0 lefttButtonText" > Today Sale Balance</h5>
      </div>
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Sale Category</th>
            <th scope="col">Net Amount</th>
            <th scope="col">Discount</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0; @endphp
        @foreach ($today_sale_balance as $item )
            
        <tr>
          <td>{{ $i++}}</td>
          <td>{{ $item->agent_name}}</td>
          <td>
            @php
                if ($item->sale_category_id == 1) {
                  echo "Flights";
                }elseif ($item->sale_category_id ==2 ) {
                  echo "Hotels";
                }elseif ($item->sale_category_id ==3 ) {
                  echo "Transfers";
                }elseif ($item->sale_category_id ==4 ) {
                  echo "Activities";
                }elseif ($item->sale_category_id ==5 ) {
                  echo "Holidays";
                }elseif ($item->sale_category_id ==6 ) {
                  echo "Visa";
                }elseif ($item->sale_category_id ==7 ) {
                  echo "Others";
                }else{
                  echo "";
                }
            @endphp  
          </td>
          <td>{{ $item->sale_amount}}</td>
          <td>{{ $item->discount}}</td>
          <td>@php  echo $item->amount; $total_amount += $item->amount;  @endphp</td>
        </tr>
        @endforeach
        <tr>
          <th colspan="5"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
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