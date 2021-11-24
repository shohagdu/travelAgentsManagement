@extends('layouts.master')
@section('title', 'Agent Record List')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/assets/datatable/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/datatable/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/datatable/css/buttons.bootstrap4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>

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
                    <h5 class="card-title mb-0 lefttButtonText" >Agent Record List</h5>
                    <a href="{{ route('add-agent')}}" class="btn btn-success btn-sm text-white rightButton">
                        <i class="mdi mdi-plus-box"></i>  Add New  </a>
                </div>
                <div class="card-body">
                    <input type="hidden" name="asset" id="asset" value="{{ asset('')}}">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <select name="country" id="country" onchange="getCity(this.value, 'city_id')"
                                    class="select2 form-select shadow-none">
                                <option value=""> Select Country</option>
                                @foreach ($country as $item )
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select name="city" id="city" class="select2 form-select shadow-none">
                                <option value=""> Select City</option>
                                @foreach ($state as $item )
                                    <option value="{{$item->id}}"> {{$item->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input name="mobile" id="mobile" class="form-control" placeholder="Mobile"/>
                        </div>
                        <div class="col-sm-2">
                            <button onclick="search_agent_reports()" id="" class="btn btn-primary"> <i class="mdi mdi-account-search"></i>Search</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="agent_list_table" class="table table-bordered table-striped">

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
            <script src="{{ asset('public/js/agent.js')}}"></script>
@endsection
