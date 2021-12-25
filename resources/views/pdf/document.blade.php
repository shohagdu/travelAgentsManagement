<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">
<table class="width-100 margin-top-10px " style="padding-top: 20px" >
    <tr>
        <td class="width-40" >
            <table class="margin-top-60px width-100" >
                <tr>
                    <td class=""> {{ ucwords($sale_invoice_information[0]->agent_name)}} </td>
                </tr>
                <tr>
                    <td> {{$sale_invoice_information[0]->address}} </td>
                </tr>
                <tr>
                    <td>{{$sale_invoice_information[0]->mobile}}, {{$sale_invoice_information[0]->email}}</td>
                </tr>
            </table>
        </td>
        <td class="text-center-invoice width-30" style="padding-top:40px">
            <span class="InvoiceNameText"> Invoice </span>
        </td>
        <td class="width-30">
            <table class="custom-table width-100 margin-top-60px"   >
                <tr>
                    <th  class="text-right width-40 paddingRight5px"> Inv. No </th>
                    <th>   {{ $sale_invoice_information[0]->invoice_no}}  </th>
                </tr>
                <tr>
                    <th class="text-right paddingRight5px"> Inv. Date </th>
                    <th>  {{ date('d M, Y', strtotime($sale_invoice_information[0]->created_at))}}  </th>
                </tr>
            </table>
        </td>

    </tr>
</table>


<div class="row margin-top-10px">
    @if($sale_invoice_information[0]->airline_id !='')
        <table class="custom-table  width-100 table" rules="all">
            <tr>
                <th> S/N</th>
                <th> Item Description</th>
                <th class="text-right paddingRight5px"> Fare</th>
                <th class="text-right paddingRight5px"> Tax</th>
                <th class="text-right paddingRight5px" > Total Fare</th>
                <th class="text-right paddingRight5px"> Commission</th>
                <th class="text-right paddingRight5px"> AIT</th>
                <th class="text-right paddingRight5px"> ADD</th>
                <th class="text-right paddingRight5px">Net Amount</th>
            </tr>
            @php $id; $sub_total = 0; $discout_total = 0; $i=1; @endphp
            @foreach($sale_invoice_information as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td > @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->fare, 2, '.', '')}}</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->tax_amount, 2, '.', '')}}</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->total_amount, 2, '.', '')}}</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->commission_amount, 2, '.', '')}}</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->ait_amount, 2, '.', '')}}</td>
                    <td class="text-right paddingRight5px">{{number_format((float)$item->add_amount, 2, '.', '')}}</td>

                    <td class="text-right paddingRight5px"> @php $net_amount = $item->net_amount; echo  number_format($net_amount, 2); $sub_total +=$net_amount; @endphp</td>
                </tr>
            @endforeach
        </table>

    @else

        <table class="custom-table  width-100">
            <tr>
                <th> S/N</th>
                <th> Item Description</th>
                <th class="text-right paddingRight5px"> Total</th>
                <th class="text-right paddingRight5px"> Discount</th>
                <th class="text-right paddingRight5px">Net Amount</th>
            </tr>
            @php $id; $sub_total = 0; $discout_total = 0; $i=1; @endphp
            @foreach($sale_invoice_information as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td> @if($item->airline_id !='') {{$item->airline_name}} @else {{$item->details}}  @endif</td>
                    <td class="text-right paddingRight5px"> {{  $item->net_amount}} </td>
                    <td class="text-right paddingRight5px">
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

                    <td class="text-right paddingRight5px"> @php $net_amount = $item->net_amount-$discount; echo number_format($net_amount,2); $sub_total +=$net_amount @endphp</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
<table class="width-100 margin-top-10px">
    <tr>
        <td class="width-60 vertical-align-top">
            @php echo  (!empty($sale_invoice_information[0]->saleRemarks)?"<b>Remarks : </b> ".$sale_invoice_information[0]->saleRemarks:'') @endphp
        </td>
        <td class="width-40">
            <table class="custom-table  width-100 ">
                <tr>
                    <th class="text-right width-40 paddingRight5px"> Sub Total</th>
                    <td class="text-right paddingRight5px">  {{ number_format((float)$sub_total, 2)}}</td>
                </tr>
                <tr>
                    <th class="text-right paddingRight5px"> Invoice Discount</th>
                    <td class="text-right paddingRight5px">
                        @php  $invoice_discount = $sale_invoice_information[0]->invoice_discount; echo number_format((float)$invoice_discount, 2)  @endphp </td>
                </tr>
                <tr>
                    <th class="text-right paddingRight5px"> Grand Total</th>
                    <td class="text-right paddingRight5px">
                        @php $grand_total = ($sub_total -  $invoice_discount); echo number_format($grand_total,2) @endphp </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="col-md-8 pt-2">
</div>
<table class="width-100 invoiceFooter">
    <tr>
        <td class="width-80" >
            <div class="InviceFooterSign"><b>Customer</b>  </div>
        </td>
        <td class="width-20 text-center-invoice">
            {{ (!empty($sale_invoice_information[0]->userName)?$sale_invoice_information[0]->userName:'') }}
            <div class="InviceFooterSign"><b>Issue By</b>  </div>
        </td>
    </tr>
</table>






