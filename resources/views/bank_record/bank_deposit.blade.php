@extends('layouts.master')
@section('title', 'Bank Deposit')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/customs.css')}}">
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-0 lefttButtonText" > Bank Deposit </h5>
        <a href="{{ route('bank_deposit_pdf')}}" target="_blank" class="btn btn-warning btn-sm text-white rightButton">
          <i class="mdi mdi-printer"></i>  Print  
        </a>
      </div>
      
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col"> Sl </th>
            <th scope="col"> Bank Name</th>
            <th scope="col" class="width-30"> Account No </th>
            <th scope="col" class="width-30"> Branch Name </th>
            <th scope="col" class="text-end width-30"> Amount </th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0;  @endphp
          @if(!empty($bank_deposit))
                @foreach ($bank_deposit as $item )
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td> {{ (!empty($item->name_name)?$item->name_name:'') }} </td>
                          <td> {{ (!empty($item->account_no)?$item->account_no:'') }} </td>
                          <td> {{ (!empty($item->branch_name)?$item->branch_name:'') }} </td>
                          <td class="text-end width-20"> {{ !empty($item->credit_amount-$item->debit_amount)?number_format($item->credit_amount-$item->debit_amount,2):'0.00' }}  @php  $total_amount+=($item->credit_amount-$item->debit_amount); @endphp </td>
                        </tr>
                @endforeach
          @endif
        <tr>
          <th colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
          <th class="text-end">  &nbsp; {{ number_format((float)$total_amount, 2)}}  </th>
        </tr>
      </table>
        <br/>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection
