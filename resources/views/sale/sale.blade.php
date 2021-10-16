@extends('layouts.master')
@section('title', 'Sale')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Sale  </h4>
            <div class="form-group row">
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Sale Category</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value=""> Select</option>
                        <option value="1"> Flights </option>
                        <option value="2"> Hotels </option>
                        <option value="3"> Transfers </option>
                        <option value="4"> Activities </option>
                        <option value="5"> Holidays </option>
                        <option value="6"> Visa </option>
                        <option value="7"> Others </option>
                    </select>
                </div>
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Agent</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value=""> Select Agent</option>
                        @foreach ($agent_info as $item)
                          <option value="{{ $item->id}}"> {{ $item->name}} </option> 
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5> Flight Information</h5>
                    <table border="1" class="table table-responsive-sm table-bordered SaleTable">
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
                            <td>
                            </td>
                            <td>
                                <select class="form-control " name="flight_id" id="flight_id_1">
                                    <option value=""> Select Flight</option>
                                    @foreach ($airline_info as $item)
                                        <option value="{{ $item->id}}"> {{ $item->airline_title}}</option>
                                    @endforeach
                                   
                                </select>
                            </td>
                            <td>
                                <input name="fare" id="fare_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="tax" id="tax_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="tax" id="tax_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="commission" id="commission_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="ait" id="ait_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="add" id="add_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="amount" id="amount_1" type="text" class="form-control input-sm" placeholder="0.00"/>
                            </td>
                        </tr>
                        </div>
                    </table>
                    <button type="button" onclick="addNewFlight();" class="btn btn-sm btn-success FlightPlusBtn"><i class="mdi mdi-plus-box-outline"></i> New </button>
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
    <script src="{{ asset('js/global.js')}}"></script>
@endsection