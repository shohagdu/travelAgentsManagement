@extends('layouts.master')
@section('title', 'Statement Report')
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
                    <form method="post" id="agentStatementForm"  action="javascript:void(0)" >
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <div class="col-sm-3"><br>
                                <h5>Balance Statement</h5>
                            </div>
                            <div class="col-sm-3">
                                <label> From Date </label>
                                <input type="text" class="form-control" name="from_date" id="from_date" placeholder="dd-mm-yyyy" autocomplete="off">
                            </div>
                            <div class="col-sm-3">
                                <label> To Date </label>
                                <input type="text" class="form-control" name="to_date" id="to_date" placeholder="dd-mm-yyyy" autocomplete="off">
                            </div>
                            <div class="col-sm-1">
                                <label> &nbsp;</label>
                                <button type="button" onclick="search_statement_reports()" id="searchStatement" class="btn btn-success text-white">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="showReports">
                        <?php
                            $i=1;
                            $balance='0.00';
                        ?>
                        <table  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Transaction Details</th>
                                    <th class="text-end">Debit</th>
                                    <th class="text-end">Credit</th>
                                    <th class="text-end">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $getTransType = getTransType();
                            @endphp
                            {{--    {{ dd($record['data']) }}--}}
                            @if(!empty($record['data']))
                                @foreach($record['data'] as $key=>$row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td nowrap="">{{ (!empty($row->trans_date)?date('d M, Y',strtotime($row->trans_date)):'') }}</td>
                                        <td>{{ (!empty($getTransType[$row->trans_type])?$getTransType[$row->trans_type]:'') }}

                                            {{ (!empty($row->remarks)?" >> ".$row->remarks:'') }}
                                            {{ (!empty($row->invoice_no)?" >> Inv. # ".$row->invoice_no:'') }}
                                            {{ (!empty($row->receipt_cheque_no)?" >> Cheque # ".$row->receipt_cheque_no:'') }}
                                            {{ (!empty($row->reference_number)?" >> Ref. No# ".$row->reference_number:'') }}
                                        </td>
                                        <td class="text-end">{{ (!empty($row->debit_amount)?$row->debit_amount:'') }}</td>
                                        <td class="text-end">
                                            {{ (!empty($row->credit_amount)?$row->credit_amount:'') }}
                                        </td>
                                        <td class="text-end">{{  number_format(($balance+=($row->debit_amount-$row->credit_amount)),2,'.','') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Please Select Filter Information</td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <!-- DataTables  -->
            <script src="{{ asset('public/assets/datatable/js/jquery.dataTables.min.js')}}"></script>
            <script src="{{ asset('public/assets/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
            <script src="{{ asset('public/assets/datatable/js/dataTables.responsive.min.js')}}"></script>
            <script src="{{ asset('public/assets/datatable/js/responsive.bootstrap4.min.js')}}"></script>
            <script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
            <script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
            <script src="{{ asset('public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
            <script src="{{ asset('public/js/report.js')}}"></script>
    @endsection
