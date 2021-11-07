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
          <div class="col-md-7 InviceLftHeader">
            <img src="{{ asset('public/assets/images')}}/{{$organization_info->logo}}"/><br>
            
            <table class="InvoiceLeftTextArea">
                <tr>
                    <td> <span class="InvoiceName"> {{$agent_info->name}} </span></td>
                </tr>
                <tr>
                    <td> <span class="Invoiceaddress"> {{$agent_info->address}} </span> </td>
                </tr>
                <tr>
                    <td> <span class="InvoiceEmail"> {{$agent_info->email}}</span> </td>
                </tr>
                <tr>
                    <td>  <span class="Invoicemobile"> {{$agent_info->mobile}}</span> </td>
                </tr>
            </table>

          </div>
          <div class="col-md-5 InvicerhtHeader">
                <span class="InvoiceNameText"> Invoice </span><br>
                <span class="InvoiceText">Invoice No : # {{ $sale_details_data[0]->sale_id}}</span> 
                
                <button type="button" onclick="printInvoiceBtn()" class="btn btn-warning btn-md topPrintbarbutton noSectionToPrint"><i class="mdi  mdi-printer"></i>
                    Print
                </button>
            <table class="InvoiceDateText">
                <tr>
                    <td> Invoice Date </td>
                    <td> : {{ date('d-m-Y', strtotime($sale_details_data[0]->created_at))}}  </td>
                </tr>
            </table><br>
            <p> Total Due : <br>
                <span class="InvoiceTotalDue">{{ number_format((float)$due_balance, 2, '.', '')}}</span>
            </p>
           </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($airline_id !='') 
                    <table class="InvoiceIteamTable">
                        <tr>
                            <th> Item Description </th>
                            <th> Fare </th>
                            <th> Tax </th>
                            <th> Total Fare </th>
                            <th> Commission</th>
                            <th> AIT</th>
                            <th> ADD</th>
                            <th> Total </th>
                            <th> Discount </th>
                            <th>Net Amount </th>
                        </tr>
                        @php $id; $sub_total = 0; $discout_total = 0; @endphp
                        @foreach($sale_details_data as $item)
                        <tr>
                
                            <td> @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                            <td>{{number_format((float)$item->fare, 2, '.', '')}}</td>
                            <td>{{number_format((float)$item->tax_amount, 2, '.', '')}}</td>
                            <td>{{number_format((float)$item->total_amount, 2, '.', '')}}</td>
                            <td>{{number_format((float)$item->commission_amount, 2, '.', '')}}</td>
                            <td>{{number_format((float)$item->ait_amount, 2, '.', '')}}</td>
                            <td>{{number_format((float)$item->add_amount, 2, '.', '')}}</td>
                            <td> {{  $item->net_amount}} </td>
                            <td> @php if($item->discount > 0 ){
                                $discount = $item->discount;
                                $discout_total += $discount;
                            echo  number_format((float)$discount, 2, '.', ''); 
                            }else{
                                $discount = 0;
                                echo  number_format((float)$discount, 2, '.', ''); 
                                }
                                @endphp
                        </td>
                        
                        <td> @php $net_amount = $item->net_amount-$discount; echo $net_amount; $sub_total +=$net_amount; @endphp</td>
                        </tr>
                        @endforeach
                    </table>

                @else

                    <table class="InvoiceIteamTable">
                        <tr>
                            <th> Item Description </th>
                            <th> Total </th>
                            <th> Discount </th>
                            <th>Net Amount </th>
                        </tr>
                        @php $id; $sub_total = 0; $discout_total = 0; @endphp
                        @foreach($sale_details_data as $item)
                        <tr>
                
                            <td> @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                            <td> {{  $item->net_amount}} </td>
                            <td> @php if($item->discount > 0 ){
                                $discount = $item->discount;
                                $discout_total += $discount;
                            echo  number_format((float)$discount, 2, '.', ''); 
                            }else{
                                $discount = 0;
                                echo  number_format((float)$discount, 2, '.', ''); 
                                }
                                @endphp
                        </td>
                        
                        <td> @php $net_amount = $item->net_amount-$discount; echo $net_amount; $sub_total +=$net_amount; @endphp</td>
                        </tr>
                        @endforeach
                    </table>

                @endif

                
            </div>
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <table class="InvoiceTotalFotaerTbl">
                    <tr>
                        <th> Sub Total </th>
                        <th> : {{ number_format((float)$sub_total, 2, '.', '')}}</th>
                    </tr>
                    {{-- <tr>
                        <th> Total Discount </th>
                        <th> :  {{ number_format((float)$discout_total, 2, '.', '')}} </th>
                    </tr> --}}
                    <tr>
                        <th> Invoice Discount </th>
                        <th> : @php  $invoice_discount = $sale_details_data[0]->invoice_discount; echo number_format((float)$invoice_discount, 2, '.', '') ; @endphp </th>
                    </tr>
                    <tr>
                        <th> Grand Total </th>
                        <th> : @php $grand_total = ($sub_total -  $invoice_discount); echo $grand_total; @endphp </th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row InvoiceFooterTEXT">
            <div class="col-md-10">
                <p>
                    <span>{{$organization_info->address}}</span><br>
                    <span>{{$organization_info->email}}</span><br>
                    <span>{{$organization_info->mobile}}</span><br>
                </p>
            </div>
            <div class="col-md-2">
               <p class="InviceFooterSign"> Company Signature</p>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script src="{{ asset('public/js/sale.js')}}"></script>
@endsection
