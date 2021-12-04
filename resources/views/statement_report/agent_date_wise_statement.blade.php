@extends('layouts.master')
@section('title', 'Agent Date Wise Statement')

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
                    <h5 class="card-title mb-0 lefttButtonText">Agent Date Wise Statement</h5>
                    <a href="{{ route('agent-date-wise-statement')}}" class="btn btn-danger btn-sm text-white rightButton"> <i class="mdi mdi-refresh"></i>  Refresh  </a>
                    <a href="" class="btn btn-warning btn-sm text-white rightButton" style="margin-right: 5px"> <i class="mdi mdi-printer"></i>  Print  </a>
                </div>
                <div class="card-body">
                    <form method="post" id="agentStatementForm"  action="javascript:void(0)" >
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label> Agent </label>
                                <select name="agent_id" id="agent_id" class="form-control">
                                    <option value=""> Select Agent</option>
                                    @foreach ($agent_info as $item )
                                        <option value="{{$item->id}}"> {{$item->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label> From Date </label>
                                <input type="text" class="form-control" name="from_date" id="from_date"
                                       placeholder="dd-mm-yyyy" autocomplete="off">
                            </div>
                            <div class="col-sm-3">
                                <label> To Date </label>
                                <input type="text" class="form-control" name="to_date" id="to_date" placeholder="dd-mm-yyyy"
                                       autocomplete="off">
                            </div>
                            <div class="col-sm-2">
                                <div style="padding-top: 27px">
                                    <button type="button" onclick="searchAgentStatementBtn()"  id="searchAgentStatement"
                                            class="btn btn-success text-white"><i class="mdi mdi-account-search"></i>Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="showReports">
                        <table  class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Transaction Details</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td colspan="6" class="text-center">Please Select Filter Information</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script src="{{ asset('public/assets/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('public/js/report.js')}}"></script>
@endsection
