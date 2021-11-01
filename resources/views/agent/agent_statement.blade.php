@extends('layouts.master')
@section('title', 'Agent Statement')
@section('main_content')
<div class="row " id="printableArea">
    <div class="col-md-12">
      <h6 class="text-center"> Agent Statement </h6>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <p class="text-center">
                <span class="statementCompany"> {{$organization_info->name}} </span>
                 <br>
                <span> Address : {{$organization_info->address}}</span><br>
                <span> Mobile  : {{$organization_info->mobile}} , Email: {{$organization_info->email}}</span>
            </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <table class="AgentInfoStatement">
                <tr>
                    <th> Agent Name</th>
                    <td> :{{$agent_info->name}}</td>
                </tr>
                <tr>
                    <th> Address </th>
                    <td> : {{$agent_info->address}}</td>
                </tr>
                <tr>
                    <th> Duration </th>
                    <td> : 01/10/2021 to 20/10/2021 </td>
                </tr>
            </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 ">
            <table class="AgentTranactionStatementListTbl">
                <tr>
                    <th>SL</th>
                    <th>Date </th>
                    <th>Transsaction details </th>
                    <th>Debit </th>
                    <th>Credit </th>
                    <th>Balance </th>
                </tr>
                @php $i=1;  $balance = 0; $dr_total = 0 ; $cr_total = 0; @endphp
                @foreach($transaction_info as $item )
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ date('d-m-Y', strtotime($item->trans_date))}}</td>
                    <td>@if($item->trans_type==1) Sale @elseif($item->trans_type ==2) Collection @endif 
                        @if($item->account_name !='') ({{$item->account_name}}) @endif
                         <br> {{$item->remarks}}</td>
                    <td> <?php 
                        if($item->trans_type ==1){ 
                            $dr = $item->debit_amount; echo $dr;
                            $dr_total = $item->debit_amount ; 
                          }else{
                            $dr = 0;
                        } ?>
                    </td>
                    <td> <?php 
                        if($item->trans_type ==2){
                             $cr = $item->credit_amount; echo $cr;
                             $cr_total = $item->credit_amount;
                             }else{
                             $cr  = 0;
                    } ?> </td>
                    <td>@php echo  $balance = $balance + ($dr - $cr) ;@endphp </td>
                </tr>
                @endforeach
            </table>
        </div>
      </div>
  </div>
@endsection
