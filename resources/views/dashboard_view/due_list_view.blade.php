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
        <h5 class="card-title mb-0 lefttButtonText" > Agent Due Statement</h5>
      </div>
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Agent Name</th>
            <th scope="col" class="width-30">Mobile</th>
            <th scope="col" class="width-30">Address</th>
            <th scope="col" class="text-end width-30">Due Amount </th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0;  @endphp
          @if(!empty($due_list_view))
                @foreach ($due_list_view as $item )
                    @if($item->debit_amount-$item->credit_amount>0)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td> {{ (!empty($item->company_name)?$item->company_name:'') }}{{ (!empty($item->agent_name)?" (".$item->agent_name.")":'') }} </td>
                          <td> {{ (!empty($item->agent_mobile)?$item->agent_mobile:'') }} </td>
                          <td> {{ (!empty($item->agent_address)?$item->agent_address:'') }} </td>
                          <td class="text-end width-20"> {{ !empty($item->debit_amount-$item->credit_amount)?number_format($item->debit_amount-$item->credit_amount,2):'0.00' }}  @php  $total_amount+=($item->debit_amount-$item->credit_amount); @endphp </td>
                        </tr>
                     @endif
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
@endsection
@section('js')
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection
