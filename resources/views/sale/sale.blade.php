@extends('layouts.master')
@section('title', 'Sale')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/libs/select2/dist/css/select2.min.css')}}"/>
@endsection
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
                <div class="card-header">
                    <h5 class="card-title mb-0 lefttButtonText"> New Sale</h5>
                    <a href="{{ route('sale-list')}}" class="btn btn-success btn-sm text-white rightButton">
                        <i class="mdi mdi-view-list"></i> List </a>
                </div>
                <form class="form-horizontal" method="POST" id="SaleForm" action="javascript:void(0)">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="sale_category_id" class="col-sm-2 text-end control-label col-form-label"> Sale
                                Category</label>
                            <div class="col-sm-4">
                                <select name="sale_category_id" id="sale_category_id"
                                        onchange="saleCategory(this.value)"
                                        class="form-control @error('sale_category_id') is-invalid @enderror">
                                    <option value=""> Select</option>
                                    @foreach($sale_category_info as $item)
                                        <option value="{{$item->id}}"> {{$item->title}} </option>
                                    @endforeach
                                </select>
                                @error('sale_category_id')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                       </span>
                                @enderror
                            </div>
                            <label for="agent_id" class="col-sm-2 text-end control-label col-form-label"> Agent</label>
                            <div class="col-sm-4">
                                <select id="agent_id" name="agent_id"
                                        class="select2 form-select shadow-none @error('agent_id') is-invalid @enderror">
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
                                <h5 id="headingText" class="text-center"> Please Select Sale Category </h5>
                                <table class="FlightSaleTable SaleTable">
                                    <tr>
                                        <th class="airlineTh"> Airline</th>
                                        <th class="fareTh"> Fare</th>
                                        <th class="TaxTh"> Tax</th>
                                        <th class="totalFareTh"> Total Fare</th>
                                        <th class="commissionTh"> Commission</th>
                                        <th class="aitTh"> AIT</th>
                                        <th class="addTh"> ADD</th>
                                        <th class="amountTh"> Amount</th>
                                        <th class="actionTh"> Action</th>
                                    </tr>
                                    <tr class="element1" id="flightAreaDiv_1">

                                        <td>
                                            <select class="FlightTd FlightInfo" name="flight_id[]" id="flight_id_1">
                                                <option value=""> Select Flight</option>
                                                @foreach ($airline_info as $item)
                                                    <option value="{{ $item->id}}"> {{ $item->airline_name}}
                                                        (@if($item->category==1) INTL @elseif($item->category==2)
                                                            DOM @endif) </option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>
                                            <input name="fare[]" id="fare_1" type="text" onkeyup="filghtCaculation(1)"
                                                   class="fareTd" placeholder="0.00"/>
                                        </td>
                                        <td>
                                            <input name="tax[]" id="tax_1" type="text" onkeyup="filghtCaculation(1)"
                                                   class="taxTd" placeholder="0.00"/>
                                        </td>
                                        <td>
                                            <input name="total_fare[]" id="totalFare_1" type="text"
                                                   onkeyup="filghtCaculation(1)" class="totalFareTd" placeholder="0.00"
                                                   readonly/>
                                        </td>
                                        <td>
                                            <input name="commission[]" id="commission_1" type="text"
                                                   onkeyup="filghtCommissionAITCaculation(1)" class="commissionTd"
                                                   placeholder="0.00"/>
                                            <input type="hidden" name="commissionPer[]" id="commissionPer_1">
                                        </td>
                                        <td>
                                            <input name="ait[]" id="ait_1" type="text"
                                                   onkeyup="filghtCommissionAITCaculation(1)" class="aitTd"
                                                   placeholder="0.00"/>
                                            <input type="hidden" name="aitPer[]" id="aitPer_1">
                                        </td>
                                        <td>
                                            <input name="add[]" id="add_1" type="text" onkeyup="filghtADDCaculation(1)"
                                                   class="AddTd" placeholder="0.00"/>
                                        </td>
                                        <td>
                                            <input name="amount[]" id="amount_1" type="text"
                                                   onkeyup="filghtCaculation(1)" class="amountTd Amount"
                                                   placeholder="0.00" readonly/>
                                        </td>
                                        <td class="actionTh">
                                            #
                                        </td>
                                    </tr>
                                </table>
                                <table class="HotelSaleTable SaleTable">
                                    <tr>

                                        <th class="DetailsTh"> Details</th>
                                        <th class="amountTh"> Amount</th>
                                        <th class="DiscountTh"> Discount</th>
                                        <th class="netTotalTh"> Net Total</th>
                                        <th class="actionTh"> Action</th>
                                    </tr>
                                    <tr class="element2" id="hotelAreaDiv_1">

                                        <td>
                                            <textarea name="details[]" id="details_1" rows="1" class="detailsTd"
                                                      placeholder="Details"></textarea>
                                        </td>
                                        <td>
                                            <input name="amount2[]" id="amountHotel_1" type="text"
                                                   onkeyup="HotelCaculation(1)" class="AmountHotel" placeholder="0.00"/>
                                        </td>
                                        <td>
                                            <input name="discount2[]" id="discountHotel_1" type="text"
                                                   onkeyup="HotelCaculation(1)" value="0.00" class="DiscountHotel"
                                                   placeholder="0.00"/>
                                        </td>
                                        <td>
                                            <input name="net_total_row[]" id="netTotal_1" type="text"
                                                   class="NetamountTd Amount" placeholder="0.00" readonly/>
                                        </td>
                                        <td class="actionTh">
                                            #
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="addNewDiv">
                            <button type="button" id="FlightPlusBtn" onclick="addNewFlight();"
                                    class="btn btn-sm btn-success FlightPlusBtn"><i
                                    class="mdi mdi-plus-box-outline"></i> Add New
                            </button>
                            <button type="button" id="HotelPlusBtn" onclick="addNewHotel();"
                                    class="btn btn-sm btn-success HotelPlusBtn"><i class="mdi mdi-plus-box-outline"></i>Add
                                New
                            </button>
                        </div>

                        <div class="row showSalesFooterInfo" style="display: none;">
                            <div class="col-md-8">
                                <textarea class="form-control SaleRemaks" rows="3" name="remarks" id="remarks"
                                          placeholder="Enter Remarks"></textarea>
                            </div>
                            <div class="col-md-4">
                                <p><span> Net Total</span>
                                    <input id="NetTotal" name="net_total" readonly type="text"
                                           class="saleFooterText @error('net_total') is-invalid @enderror"
                                           placeholder="0.00">
                                    @error('net_total')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>
                                <p><span> Discount</span>
                                    <input id="Discount" onkeyup="DiscountSale()" name="discount" type="text"
                                           class="saleFooterText" value="0.00">
                                </p>
                                <p><span> Invoice Amount</span>
                                    <input id="invoice_amount" name="invoice_amount" readonly type="text"
                                           class="saleFooterText @error('invoice_amount') is-invalid @enderror"
                                           placeholder="0.00">
                                    @error('invoice_amount')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </p>
                                <p>
                                    <input type="hidden" name="target" id="target" value="{{ asset('')}}">
                                    <button type="submit" id="SaleSaveBtn" class="btn btn-primary FlightSaveBtn">
                                        Save
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
    <script src="{{ asset('public/js/sweetalert.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('public/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{ asset('public/js/sale.js')}}"></script>
@endsection
