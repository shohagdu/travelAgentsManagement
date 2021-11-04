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
              <div class="card card-hover">
                <div class="box todaySaleShow text-center">
                  <h1 class="font-light text-white">
                    {{$today_total_sale}}
                  </h1>
                  <h6 class="text-white">Today Sale</h6>
                </div>
              </div>
            </div>
             <!-- Column -->
             <div class="col-md-6 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-secondary text-center">
                  <h1 class="font-light text-white">
                    {{$today_total_collection}}
                  </h1>
                  <h6 class="text-white">Today Collection </h6>
                </div>
              </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-warning text-center">
                  <h1 class="font-light text-white">
                    {{$today_total_refund}}
                  </h1>
                  <h6 class="text-white">Today Refund </h6>
                </div>
              </div>
            </div>
           
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-info text-center">
                  <h1 class="font-light text-white">
                    {{$total_agent}}
                  </h1>
                  <h6 class="text-white">Total Agent</h6>
                </div>
              </div>
            </div>
            
             <!-- Column -->
             <div class="col-md-6 col-lg-4 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-success text-center">
                  <h1 class="font-light text-white">
                    {{ $total_sale}} 
                  </h1>
                  <h6 class="text-white">Total Sale </h6>
                </div>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-primary text-center">
                  <h1 class="font-light text-white">
                    {{ $total_collection}} 
                  </h1>
                  <h6 class="text-white"> Total Collection</h6>
                </div>
              </div>
            </div>
             <!-- Column -->
             <div class="col-md-6 col-lg-4 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-danger text-center">
                  <h1 class="font-light text-white">
                    {{ $total_refund}} 
                  </h1>
                  <h6 class="text-white"> Total Refund </h6>
                </div>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
@endsection