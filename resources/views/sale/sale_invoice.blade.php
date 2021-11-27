@extends('layouts.master')
@section('title', 'Sale Invoice')
@section('css')
    <link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">
@endsection
@section('main_content')
    <div class="row">
        <div class="col-md-12" id="section-to-print">
            <div class="card card-body printableArea">
                <div class="row">

                    <div class="col-md-3 " >
                        <table class="InvoiceLeftTextArea" style="width: 100%">
                            <tr>
                                <td class=""><span class="InvoiceName"> {{ (!empty($agent_info->name)?ucwords($agent_info->name):'')}} </span></td>
                            </tr>
                            <tr>
                                <td><span class="Invoiceaddress"> {{$agent_info->address}} </span></td>
                            </tr>
                            <tr>
                                <td><span class="InvoiceEmail">{{$agent_info->mobile}}, {{$agent_info->email}}</span></td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-sm-6 InviceLftHeader text-center">
                        <img src="{{ asset('public/assets/images')}}/{{$organization_info->logo}}"/>
                        <div class="invoiceCompanyAddress">
                            <span>{{$organization_info->address}}</span>,
                           <br/>
                            www.tripayan.com, <span>{{(!empty($organization_info->mobile)?$organization_info->mobile:'')}}</span>,<span> {{$organization_info->email}}</span>
                        </div>
                        <div class="InvoiceNameText"> Invoice </div>
                    </div>
                    <div class="col-md-3 InvicerhtHeader">
                         <a href="{{ url('salesInvoicePdf/'.(!empty($sale_info->id)?$sale_info->id:'')) }}" target="_blank"
                                class="btn btn-warning btn-md topPrintbarbutton noSectionToPrint"><i
                                class="mdi  mdi-printer"></i>
                             Print
                        </a>

                        <div class="clearfix"></div>
                        <table class="InvoiceDateText" style="width: 100%;margin-top: 5px">
                            <tr>
                                <th style="width:30% !important;" class="text-end"> Inv. No</th>
                                <th>   {{ $sale_details_data[0]->sale_id}}  </th>
                            </tr>
                            <tr>
                                <th class="text-end"> Inv. Date</th>
                                <th>  {{ date('d M, Y', strtotime($sale_details_data[0]->created_at))}}  </th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($airline_id !='')
                            <table class="InvoiceIteamTable">
                                <tr>
                                    <th> S/N</th>
                                    <th> Item Description</th>
                                    <th class="text-center"> Fare</th>
                                    <th class="text-center"> Tax</th>
                                    <th class="text-center" > Total Fare</th>
                                    <th class="text-center"> Commission</th>
                                    <th class="text-center"> AIT</th>
                                    <th class="text-center"> ADD</th>
                                    <th class="text-center">Net Amount</th>
                                </tr>
                                @php $id; $sub_total = 0; $discout_total = 0; $i=1; @endphp
                                @foreach($sale_details_data as $item)
                                    <tr>
                                         <td>{{ $i++ }}</td>
                                        <td > @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                                        <td class="text-end">{{number_format((float)$item->fare, 2, '.', '')}}</td>
                                        <td class="text-end">{{number_format((float)$item->tax_amount, 2, '.', '')}}</td>
                                        <td class="text-end">{{number_format((float)$item->total_amount, 2, '.', '')}}</td>
                                        <td class="text-end">{{number_format((float)$item->commission_amount, 2, '.', '')}}</td>
                                        <td class="text-end">{{number_format((float)$item->ait_amount, 2, '.', '')}}</td>
                                        <td class="text-end">{{number_format((float)$item->add_amount, 2, '.', '')}}</td>

                                        <td class="text-end"> @php $net_amount = $item->net_amount; echo  number_format($net_amount, 2); $sub_total +=$net_amount; @endphp</td>
                                    </tr>
                                @endforeach
                            </table>

                        @else

                            <table class="InvoiceIteamTable">
                                <tr>
                                    <th> S/N</th>
                                    <th> Item Description</th>
                                    <th> Total</th>
                                    <th> Discount</th>
                                    <th class="text-end">Net Amount</th>
                                </tr>
                                @php $id; $sub_total = 0; $discout_total = 0; $i=1; @endphp
                                @foreach($sale_details_data as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                                        <td> {{  $item->net_amount}} </td>
                                        <td>
                                            @php
                                                if($item->discount > 0 ){
                                                    $discount = $item->discount;
                                                    $discout_total += $discount;
                                                    echo  number_format((float)$discount, 2, '.', '');
                                                }else{
                                                    $discount = 0;
                                                    echo  number_format((float)$discount, 2, '.', '');
                                                }
                                            @endphp
                                        </td>

                                        <td class="text-end"> @php $net_amount = $item->net_amount-$discount; echo number_format($net_amount,2); $sub_total +=$net_amount @endphp</td>
                                    </tr>
                                @endforeach
                            </table>

                        @endif


                    </div>
                    <div class="col-md-8 pt-2">
                        @php echo  (!empty($sale_info->remarks)?"<b>Remarks:</b> ".$sale_info->remarks:'') @endphp
                    </div>
                    <div class="col-md-4">
                        <table class="InvoiceTotalFotaerTbl">
                            <tr>
                                <th class="text-end"> Sub Total</th>
                                <td class="text-end">  {{ number_format((float)$sub_total, 2)}}</td>
                            </tr>
                            {{-- <tr>
                                <th> Total Discount </th>
                                <th> :  {{ number_format((float)$discout_total, 2, '.', '')}} </th>
                            </tr> --}}
                            <tr>
                                <th class="text-end"> Invoice Discount</th>
                                <td class="text-end">
                                     @php  $invoice_discount = $sale_details_data[0]->invoice_discount; echo number_format((float)$invoice_discount, 2)  @endphp </td>
                            </tr>
                            <tr>
                                <th class="text-end"> Grand Total</th>
                                <td class="text-end">
                                     @php $grand_total = ($sub_total -  $invoice_discount); echo number_format($grand_total,2) @endphp </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row InvoiceFooterTEXT">
                    <div class="col-md-10">
                       <i>
                           If you have any question, please contact  <span>{{(!empty($organization_info->mobile)?$organization_info->mobile:'')}}</span>,<span> {{$organization_info->email}}</span>
                       </i>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">{{ (!empty($sale_info->userName)?$sale_info->userName:'') }}</div>
                        <div class="InviceFooterSign"><b>Issue By</b>  </div>
                    </div>
                    <div class="col-md-12 text-center copyrightInvoice">
                        Software Developed by &copy; <a href="https://steptechbd.com" target="_blank">Step Technology.</a> www.steptechbd.com
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/js/sale.js')}}"></script>
@endsection
