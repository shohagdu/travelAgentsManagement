@extends('layouts.master')
@section('title', 'Dashboard')
@section('breadcrumb')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">


                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('main_content')
    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white" href="{{ route('today-sale-balance-view') }}">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white">
                            {{$today_sale_balance}}
                        </h1>
                        <h6 class="text-white"> Today Sale Balance</h6>
                        <a href="{{ route('today-sale-balance-view') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">
                            {{$today_credit_balance}}
                        </h1>
                        <h6 class="text-white">Today Credit Balance </h6>
                        <a href="{{ route('today-credit-balance-view') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box bg-primary text-center">
                        <h1 class="font-light text-white">
                            {{$today_debit_balance}}
                        </h1>
                        <h6 class="text-white"> Today Debit Balance </h6>
                        <a href="{{ route('today-debit-balance-view') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box bg-secondary text-center">
                        <h1 class="font-light text-white">
                            {{$total_agent}}
                        </h1>
                        <h6 class="text-white">Total Agent</h6>
                        <a href="{{ route('agent-list') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>

        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box CurrentTodayBalanceTxtBg text-center">
                        <h1 class="font-light text-white">
                            {{ (!empty($todayTransaction)?$todayTransaction:'0.00') }}
                        </h1>
                        <h6 class="text-white">Today Balance</h6>
                        <a href="{{ route('dailyStatement') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box CurrentDueAmountTxtBg text-center">
                        <h1 class="font-light text-white"> @if($currentDueAmount->dueAmount < 0 || empty($currentDueAmount->dueAmount))
                                                             0.00
                                                            @else
                                                            {{$currentDueAmount->dueAmount}}
                                                            @endif
                        </h1>
                        <h6 class="text-white">Current Due Amount</h6>
                        <a href="{{ route('due_list_view') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>

         <!-- Column -->
         <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box CurrentAdvanceAmountTxtBg text-center">
                        <h1 class="font-light text-white">
                            @if($currentDueAmount->dueAmount < 0 || empty($currentDueAmount->dueAmount))
                            {{ number_format((float) abs($currentDueAmount->dueAmount), 2)}}
                           @else
                           0.00
                           @endif
                        </h1>
                        <h6 class="text-white">Current Advance Amount</h6>
                        <a href="{{ route('advance_list_view') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
         <!-- Column -->
         <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box BankDepositTxtBg text-center">
                        <h1 class="font-light text-white">
                            @php
                             $get_credit_deposit = ($get_credit_deposit->creditAmount > 0 ) ?  $get_credit_deposit->creditAmount : 0;
                             $get_debit_deposit  = ($get_debit_deposit->debitAmount > 0) ?  $get_debit_deposit->debitAmount : 0;
                             $deposit = ($get_credit_deposit - $get_debit_deposit);
                              echo number_format((float) $deposit, 2);
                             @endphp

                        </h1>
                        <h6 class="text-white">Bank  Deposit Amount</h6>
                        <a href="{{ url('bank-deposit') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>
          <!-- Column -->
         <div class="col-md-6 col-lg-3 col-xlg-3">
            <a class="text-white">
                <div class="card">
                    <div class="box IATAAmountTxtBg text-center">
                        <h1 class="font-light text-white">
                           {{ !empty($get_iata_amount) ? number_format((float) $get_iata_amount, 2) : 0.00}}
                        </h1>
                        <h6 class="text-white"> IATA Amount </h6>
                        <a href="{{ url('iata-statement') }}" class="btn btn-xs btn-warning text-white"> <i
                                class="mdi mdi-view-day"></i> View </a>
                    </div>
                </div>
            </a>
        </div>

    </div>

@endsection
