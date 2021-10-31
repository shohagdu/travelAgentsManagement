@extends('layouts.master')
@section('title', 'Update Sale')
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
        <form class="form-horizontal" method="POST" id="SaleFormUpdate" action="javascript:void(0)">
                @csrf
          <div class="card-body">
            <h4 class="card-tisale_category_idtle"> Update Sale  </h4>
            <div class="form-group row">
                <label for="sale_category_id" class="col-sm-2 text-end control-label col-form-label"> Sale Category</label>
                <div class="col-sm-4">
                    <select name="sale_category_id" id="sale_category_id" onchange="saleCategory(this.value)" class="form-control @error('sale_category_id') is-invalid @enderror" readonly>
                        <option value=""> Select</option>
                        <option value="1" @if($sale_data->sale_category_id == 1) selected @endif> Flights </option>
                        <option value="2" @if($sale_data->sale_category_id == 2) selected @endif> Hotels </option>
                        <option value="3" @if($sale_data->sale_category_id == 3) selected @endif> Transfers </option>
                        <option value="4" @if($sale_data->sale_category_id == 4) selected @endif> Activities </option>
                        <option value="5" @if($sale_data->sale_category_id == 5) selected @endif> Holidays </option>
                        <option value="6" @if($sale_data->sale_category_id == 6) selected @endif> Visa </option>
                        <option value="7" @if($sale_data->sale_category_id == 7) selected @endif> Others </option>
                    </select>
                    @error('sale_category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
                <label for="agent_id" class="col-sm-2 text-end control-label col-form-label"> Agent</label>
                <div class="col-sm-4">
                    <select id="agent_id" name="agent_id" class="form-control @error('agent_id') is-invalid @enderror" readonly>
                        <option value=""> Select Agent</option>
                        @foreach ($agent_info as $item)
                          <option value="{{ $item->id}}" @if($sale_data->agent_id == $item->id) selected @endif> {{ $item->name}} </option> 
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
                    <h5 id=""> Flight Information </h5>
                    @if($sale_data->sale_category_id== 1)
                    <table  class="FlightSaleTable2 SaleTable">
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
                        @foreach($sale_details as  $key=> $data)
                        <tr  class="element1"  id="flightAreaDiv_{{ $key+1}}">
                            <input type="hidden" name="data_primary_id[]" id="data_primary_id" value="{{  $data->id}}">
                            <td class="actionTh">
                            </td>
                            <td>
                                <select class="FlightTd FlightInfo" name="flight_id[]" id="flight_id_{{ $key+1}}">
                                    <option value=""> Select Flight</option>
                                    @foreach ($airline_info as $item)
                                        <option value="{{ $item->id}}" @if($data->airline_id == $item->id) selected @endif> {{ $item->airline_name}} (@if($item->category==1) INTL @elseif($item->category==2) DOM @endif) </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input name="fare[]" id="fare_{{ $key+1}}" type="text" onkeyup="filghtCaculation({{ $key+1}})"  class="fareTd" value="{{$data->fare}}"/>
                            </td>
                            <td>
                                <input name="tax[]" id="tax_{{ $key+1}}" type="text"  onkeyup="filghtCaculation({{ $key+1}})" class="taxTd"  value="{{$data->tax_per}}"/>
                            </td>
                            <td>
                                <input name="total_fare[]" id="totalFare_{{ $key+1}}" type="text"  onkeyup="filghtCaculation({{ $key+1}})"  value="{{$data->total_amount}}" class="totalFareTd" placeholder="0.00" readonly/>
                            </td>
                            <td>
                                <input name="commission[]" id="commission_{{ $key+1}}" type="text"  onkeyup="filghtCommissionAITCaculation({{ $key+1}})"  value="{{$data->commission_amount}}" class="commissionTd" placeholder="0.00"/>
                                <input name="commissionPer[]" id="commissionPer_{{ $key+1}}" type="hidden"  value="{{$data->commission_per}}"/>
                            </td>
                            <td>
                                <input name="ait[]" id="ait_{{ $key+1}}" type="text"  onkeyup="filghtCommissionAITCaculation({{ $key+1}})" class="aitTd"  value="{{$data->ait_amount}}"/>
                                <input name="aitPer[]" id="aitPer_{{ $key+1}}" type="hidden"  value="{{$data->ait_per}}"/>
                            </td>
                            <td>
                                <input name="add[]" id="add_{{ $key+1}}" type="text"  onkeyup="filghtCaculation({{ $key+1}})" class="AddTd"  value="{{$data->add_amount}}"/>
                            </td>
                            <td>
                                <input name="amount[]" id="amount_{{ $key+1}}" type="text"  onkeyup="filghtCaculation({{ $key+1}})" class="amountTd Amount"  value="{{$data->net_amount}}" readonly/>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <table  class="HotelSaleTable2 SaleTable">
                        <tr>
                            <th class="actionTh"> Action</th>
                            <th class="DetailsTh"> Details</th>
                            <th class="amountTh"> Amount</th>
                            <th class="DiscountTh"> Discount</th>
                            <th class="netTotalTh"> Net Total</th>
                        </tr>
                        @foreach($sale_details as $k=> $value)
                        <tr  class="element2"  id="hotelAreaDiv_{{ $k+1}}">
                            <input type="hidden" name="data_primary_id2[]" id="data_primary_id2" value="{{  $value->id}}">
                            <td class="actionTh">
                            </td>
                            <td>
                                <textarea name="details[]" id="details_{{ $k+1}}" rows="1" class="detailsTd" placeholder="Details">{{ $value->details}}</textarea>
                            </td>
                            <td>
                                <input name="amount2[]" id="amountHotel_{{ $k+1}}" type="text"  onkeyup="HotelCaculation(1)" class="AmountHotel" value="{{ $value->net_amount}}"/>
                            </td>
                            <td>
                                <input name="discount2[]" id="discountHotel_{{ $k+1}}" type="text"  onkeyup="HotelCaculation(1)" value="{{ $value->discount}}" class="DiscountHotel" placeholder="0.00"/>
                            </td>
                            <td>
                                <input name="net_total_row[]" id="netTotal_{{ $k+1}}" type="text"  class="NetamountTd Amount" value="{{ $value->invoice_amount}}"readonly/>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </div>
            </div><br>
            @if($sale_data->sale_category_id== 1)
            <button type="button" id="FlightPlusBtn" onclick="addNewFlight();" class="btn btn-sm btn-success "><i class="mdi mdi-plus-box-outline"></i> New </button>
            @else
            <button type="button" id="HotelPlusBtn" onclick="addNewHotel();" class="btn btn-sm btn-success "><i class="mdi mdi-plus-box-outline"></i> New </button>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <textarea class="form-control SaleRemaks" rows="3" name="remarks" id="remarks" placeholder="Remarks"> {{ $transaction_data->remarks}} </textarea>
                </div>
                <div class="col-md-4" >
                   <p> <span style="width: 100px"> Net Total</span> 
                        <input id="NetTotal" name="net_total" type="text" class="saleFooterText @error('net_total') is-invalid @enderror" value="{{ $sale_data->sale_amount}}">
                        @error('net_total')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </p>
                   <p> <span style="width: 100px"> Discount</span> 
                    <input id="Discount" onkeyup="DiscountSale()" name="discount" type="text" class="saleFooterText"  value="{{ $sale_data->discount}}">
                   </p>
                   <p> <span style="width: 100px"> Invoice Amount</span> 
                    <input id="invoice_amount" name="invoice_amount" type="text" class="saleFooterText @error('invoice_amount') is-invalid @enderror"  value="{{ $sale_data->amount}}">
                    @error('invoice_amount')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                   </p>
                   <p>
                    <input type="hidden" name="target" id="target" value="{{ asset('')}}">
                    <input type="hidden" name="id" id="id" value="{{ $sale_data->id}}">
                    <button type="submit" id="SaleSaveBtn" class="btn btn-info FlightSaveBtn">
                        Update
                      </button>
                   </p>
        
                </div>
            </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script src="{{ asset('js/sweetalert.min.js')}}"></script>
    <script src="{{ asset('js/sale.js')}}"></script>
@endsection