@extends('layouts.master')
@section('title', 'Agent Statement')
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
                <div class="card-header">
                    <h5 class="card-title mb-0 lefttButtonText" >Agent Statement</h5>
                    <a href="{{ route('agent-list')}}" class="btn btn-danger btn-sm text-white rightButton">
                        <i class="mdi mdi-backburger"></i>  Back  </a>
                    <a href="{{ url('pdf_agent_statement/'.$agent_info->id)}}" style="margin-right:5px" target="_blank" class="btn btn-warning btn-sm text-white rightButton">
                        <i class="mdi mdi-printer"></i>  Print  </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <p class="text-center">
                                <span class="statementCompany"> {{$organization_info->name}} </span>
                                <br>
                                <span> Address : {{$organization_info->address}}</span><br>
                                <span> Mobile  : {{$organization_info->mobile}} , Email: {{$organization_info->email}}</span>
                            </p>
                        </div>
                    </div>
                    <table class="AgentInfoStatement">
                        <tr>
                            <th> Agent Name</th>
                            <td> {{$agent_info->name}}</td>
                        </tr>
                        <tr>
                            <th> Address </th>
                            <td>  {{$agent_info->address}}</td>
                        </tr>
                        <tr>
                            <th> Duration </th>
                            <td>  {{date('d-m-Y', strtotime($frist_date))}} to {{date('d-m-Y', strtotime($last_date))}}  </td>
                        </tr>
                    </table>
                    <table class="AgentTranactionStatementListTbl table table-bordered">
                        <tr>
                            <th class="width-10">SL</th>
                            <th class="width-10">Date </th>
                            <th >Transaction Details </th>
                            <th class="text-center">Debit </th>
                            <th class="text-center">Credit </th>
                            <th class="text-center">Balance </th>
                        </tr>
                        @php $i=1;  $balance = 0; $dr_total = 0 ; $cr_total = 0; @endphp
                        @foreach($transaction_info as $item )
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ date('d M, Y', strtotime($item->trans_date))}}</td>
                                <td>
                                    @if($item->trans_type==1) Sale @elseif($item->trans_type ==2) Credit Bill @elseif($item->trans_type ==3) Debit Bill @endif
                                    @if($item->account_name !='') ({{$item->account_name}}) @endif
                                     {{ (!empty($item->remarks)?" >> ".$item->remarks:'') }}
                                </td>
                                <td class="text-end">
                                    <?php
                                        if($item->trans_type ==1 || $item->trans_type ==3 ){
                                            $dr = $item->debit_amount; echo $dr;
                                            $dr_total += $item->debit_amount ;
                                        }else{
                                            $dr = '0.00';
                                            echo '-';
                                        }
                                    ?>
                                </td>
                                <td class="text-end">
                                    <?php
                                        if($item->trans_type ==2){
                                            $cr = $item->credit_amount;
                                            echo !empty($cr)?$cr:'0.00';
                                            $cr_total += $item->credit_amount;
                                        }else{
                                            $cr  = '0.00';
                                            echo '-';
                                        }
                                    ?>
                                </td>
                                <td class="text-end">@php   $balance = $balance + ($dr - $cr) ; echo (!empty($balance)?number_format($balance,2):'0.00') @endphp </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3"> <span class="SalatemtTotal"> Total</span></th>
                            <th class="text-end"> {{ $dr_total}}</th>
                            <th class="text-end"> {{ $cr_total}}</th>
                            <th class="text-end"> {{ number_format($dr_total-$cr_total,2) }}</th>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    @endsection



