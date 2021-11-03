@extends('layouts.master')
@section('title', 'Sale Invoice')
@section('css')
<link rel="stylesheet" href="{{ asset('css/invoice.css')}}">
@endsection
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card card-body printableArea">  
        <div class="row">
          <div class="col-md-7 InviceLftHeader">
            <img style="height: 90px;" src="{{ asset('assets/images')}}/{{$organization_info->logo}}"/><br>
            
            <table class="InvoiceLeftTextArea">
                <tr>
                    <td> <span class="InvoiceName"> {{$agent_info->name}}</span></td>
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
                <span class="InvoiceText">Invoice No : #2021001</span> 
            <table class="InvoiceDateText">
                <tr>
                    <td> Incoice Date </td>
                    <td> : {{ date('d-m-Y', strtotime($sale_details_data[0]->created_at))}}  </td>
                </tr>
                <tr>
                    <td> Issue  Date </td>
                    <td> : 08/10/2021  </td>
                </tr>
                <tr>
                    <td> Account No </td>
                    <td> : 1231234242  </td>
                </tr>
            </table><br>
            <p> Total Due : <br>
                <span class="InvoiceTotalDue">10800.00</span>
            </p>
           </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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

function reviewADD(){
    var comt = lelfesdf;
    rattint -5;

    $("#parent").append($('<td>Whatever</td>').click(
  function() {
    alert(bar);
  }));

}
