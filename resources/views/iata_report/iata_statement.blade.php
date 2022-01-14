@extends('layouts.master')
@section('title', 'IATA Statement')
@section('css')
<link rel="stylesheet" type="text/css"href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>
@endsection
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
                    <h5 class="card-title mb-0 lefttButtonText">IATA Statement </h5>
                    <a href="{{ route('iata_statement')}}" class="btn btn-danger btn-sm text-white rightButton"> <i class="mdi mdi-refresh"></i>  Refresh  </a>

                </div>
                <div class="card-body">
                    <form method="post" id="iataStatementForm"  action="javascript:void(0)" >
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
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
                                    <button type="button" onclick="searchIataStatementBtn()"  id="searchBankStatement"
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
                                    <th>Remarks</th>
                                    <th>Type</th>
                                    <th class="text-end">Sales  </th>
                                    <th class="text-end">Debit  </th>
                                    <th class="text-end">Credit  </th>
                                    <th class="text-end">Balance </th>
                                </tr>
                            </thead>
                            <tbody>
                                <td colspan="8" class="text-center">Please Select Filter Information</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script src="{{ asset('public/assets/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('public/js/iota.js')}}"></script>
@endsection
