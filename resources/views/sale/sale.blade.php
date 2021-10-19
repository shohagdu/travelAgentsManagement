@extends('layouts.master')
@section('title', 'Sale')
@section('main_content')
<div class="row">
    <div class="col-md-12">
        @if (session()->has('flash.message'))
        <div class="alert alert-{{ session('flash.class') }} alert-dismissible fade show" role="alert">
          {{ session('flash.message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('sale-save')}}">
                @csrf
          <div class="card-body">
            <h4 class="card-tisale_category_idtle"> Sale  </h4>
            <div class="form-group row">
                <label for="sale_category_id" class="col-sm-2 text-end control-label col-form-label"> Sale Category</label>
                <div class="col-sm-4">
                    <select name="sale_category_id" id="sale_category_id" class="form-control @error('sale_category_id') is-invalid @enderror">
                        <option value=""> Select</option>
                        <option value="1"> Flights </option>
                        <option value="2"> Hotels </option>
                        <option value="3"> Transfers </option>
                        <option value="4"> Activities </option>
                        <option value="5"> Holidays </option>
                        <option value="6"> Visa </option>
                        <option value="7"> Others </option>
                    </select>
                    @error('sale_category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
                <label for="agent_id" class="col-sm-2 text-end control-label col-form-label"> Agent</label>
                <div class="col-sm-4">
                    <select id="agent_id" name="agent_id" class="form-control @error('agent_id') is-invalid @enderror">
                        <option value=""> Select Agent</option>
                        @foreach ($agent_info as $item)
                          <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                        @endforeach
                    </select>
                    @error('agent_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <h5> Flight Information</h5>
                    <table  class="FlightSaleTable SaleTable">
                        <tr>
                            <th class="actionTh"> Action</th>
                            <th class="airlineTh"> Airline</th>
                            <th class="fareTh"> Fare</th>
                            <th class="TaxTh"> Tax</th>
                            <th class="totalFareTh"> Total fare</th>
                            <th class="commissionTh"> Commission</th>
                            <th class="aitTh"> AIT</th>
                            <th class="addTh"> Add </th>
                            <th class="amountTh"> Amount</th>
                        </tr>
                        <tr  class="element1"  id="flightAreaDiv_1">
                            <td class="actionTh">
                            </td>
                            <td>
                                <select class="FlightTd FlightInfo" name="flight_id[]" id="flight_id_1">
                                    <option value=""> Select Flight</option>
                                    @foreach ($airline_info as $item)
                                        <option value="{{ $item->id}}"> {{ $item->airline_title}}</option>
                                    @endforeach
                                   
                                </select>
                            </td>
                            <td>
                                <input name="fare[]" id="fare_1" type="text" onkeyup="filghtCaculation(1)"  class="fareTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="tax[]" id="tax_1" type="text"  onkeyup="filghtCaculation(1)" class="taxTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="total_fare[]" id="totalFare_1" type="text"  onkeyup="filghtCaculation(1)" class="totalFareTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="commission[]" id="commission_1" type="text"  onkeyup="filghtCaculation(1)" class="commissionTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="ait[]" id="ait_1" type="text"  onkeyup="filghtCaculation(1)" class="aitTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="add[]" id="add_1" type="text"  onkeyup="filghtCaculation(1)" class="AddTd" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="amount[]" id="amount_1" type="text"  onkeyup="filghtCaculation(1)" class="amountTd Amount" placeholder="0.00"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"><br>
                    <button type="button" onclick="addNewFlight();" class="btn btn-sm btn-success FlightPlusBtn"><i class="mdi mdi-plus-box-outline"></i> New </button>
                </div>
                <div class="col-md-1"><br> <label> Total </label> </div>
                <div class="col-md-3"><br>
                     <input id="NetTotal" name="net_total" type="text" class=" @error('net_total') is-invalid @enderror">
                     @error('net_total')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror 
                </div>
            </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary FlightSaveBtn">
                Save
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
    <script src="{{ asset('js/sale.js')}}"></script>
@endsection