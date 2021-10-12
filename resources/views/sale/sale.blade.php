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
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Agent</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value=""> Select Agent</option>
                        <option value="1"> Jabed </option>
                        <option value="1"> Humayon </option>
                    </select>
                </div>
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
            </div>
            <div class="row">
                <hr>
                <div class="col-md-12 element1"  id="flightAreaDiv_1">
                    <h5> Flight Information</h5>
                    <table border="1" class="table table-bordered">
                        <tr>
                            <th class="airlineTh"> Airline</th>
                            <th class="fareTh"> Fare</th>
                            <th class="TaxTh"> Tax</th>
                            <th class="totalFareTh"> Total fare</th>
                            <th class="commissionTh"> Commission</th>
                            <th class="aitTh"> Ait</th>
                            <th class="addTh"> Add </th>
                            <th class="amountTh"> Amount</th>
                            <th class="actionTh"> Action</th>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" name="flight_id" id="flight_id">
                                    <option value=""> Select Flight</option>
                                </select>
                            </td>
                            <td>
                                <input name="fare" id="fare" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="tax" id="tax" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="tax" id="tax" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="commission" id="commission" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="ait" id="ait" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="add" id="add" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="amount" id="amount" type="text" class="form-control" placeholder="0.00"/>
                            </td>
                            <td>
                                <button type="button" onclick="addNewFlight();" class="btn btn-sm btn-success FlightPlusBtn"><i class="mdi mdi-plus-box-outline"></i> </button>
                            </td>
                        </tr>
                    </table>
            </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary">
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