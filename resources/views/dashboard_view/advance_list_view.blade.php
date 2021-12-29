@extends('layouts.master')
@section('title', 'Agent Advance Statement')
@section('css')
<link rel="stylesheet" href="{{ asset('public/assets/customs.css')}}">
<link rel="stylesheet" type="text/css"href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>
@endsection
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-0 lefttButtonText" > Agent Advance Statement</h5>
      </div>
      <form method="post" action="{{ route('agent-advance-balance-view')}}" >
        @csrf
      <div class="form-group row">
        <div class="col-sm-1"></div>
        <div class="col-sm-2">
          <label> Agent Name </label>
        </div>
      <div class="col-sm-4">
          <select name="agent_id" id="agent_id" class="select2 form-select shadow-none">
              <option value=""> Select </option>
              @foreach ($agent_info as $item )
              <option value="{{$item->id}}"> {{$item->name}} ({{$item->company_name}})</option>
              @endforeach
          </select>
      </div>
      <div class="col-sm-1">
          <button type="submit" id="" class="btn btn-success text-white">Search</button>
      </div>
    </div>
    </form>
      <table class="TodaySaleBalanceTbl" >
        <thead>
          <tr>
            <th scope="col">Sl</th>
            <th scope="col">Agent Name</th>
            <th scope="col" class="width-30">Mobile</th>
            <th scope="col" class="width-30">Address</th>
            <th scope="col" class="text-end width-30">Advance Amount </th>
          </tr>
        </thead>
        @php $i=1; $total_amount=0;  @endphp
          @if(!empty($advance_list_view))
                @foreach ($advance_list_view as $item )
                    @if($item->debit_amount-$item->credit_amount < 0)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td> {{ (!empty($item->company_name)?$item->company_name:'') }}{{ (!empty($item->agent_name)?" (".$item->agent_name.")":'') }} </td>
                          <td> {{ (!empty($item->agent_mobile)?$item->agent_mobile:'') }} </td>
                          <td> {{ (!empty($item->agent_address)?$item->agent_address:'') }} </td>
                          <td class="text-end width-20"> {{ !empty($item->debit_amount-$item->credit_amount)?number_format(abs($item->debit_amount-$item->credit_amount),2):'0.00' }}  @php  $total_amount+=($item->debit_amount-$item->credit_amount); @endphp </td>
                        </tr>
                     @endif
                @endforeach
          @endif
        <tr>
          <th colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
          <th class="text-end">  &nbsp; {{ number_format((float) abs($total_amount), 2)}}  </th>
        </tr>
      </table>
        <br/>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection
