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
                    <td class=""> {{ (!empty($agent_info->name)?ucwords($agent_info->name):'')}} </td>
                </tr>
                <tr>
                    <td> {{$agent_info->address}} </td>
                </tr>
                <tr>
                    <td>{{$agent_info->mobile}}, {{$agent_info->email}}</td>
                </tr>
            </table>
        </td>
        <td class="text-center-invoice width-30" style="padding-top:40px">
            <span class="InvoiceNameText"> Invoice </span>
        </td>
        <td class="width-30">
            <table class="custom-table width-100 margin-top-60px"   >
                <tr>
                    <th  class="text-right width-40"> Inv. No</th>
                    <th>   {{ $sale_details_data[0]->sale_id}}  </th>
                </tr>
                <tr>
                    <th class="text-right"> Inv. Date</th>
                    <th>  {{ date('d M, Y', strtotime($sale_details_data[0]->created_at))}}  </th>
                </tr>
            </table>
        </td>

    </tr>
</table>


<div class="row margin-top-10px">
    @if($airline_id !='')
        <table class="custom-table  width-100 table" rules="all">
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
                    <td class="text-right">{{number_format((float)$item->fare, 2, '.', '')}}</td>
                    <td class="text-right">{{number_format((float)$item->tax_amount, 2, '.', '')}}</td>
                    <td class="text-right">{{number_format((float)$item->total_amount, 2, '.', '')}}</td>
                    <td class="text-right">{{number_format((float)$item->commission_amount, 2, '.', '')}}</td>
                    <td class="text-right">{{number_format((float)$item->ait_amount, 2, '.', '')}}</td>
                    <td class="text-right">{{number_format((float)$item->add_amount, 2, '.', '')}}</td>

                    <td class="text-right"> @php $net_amount = $item->net_amount; echo  number_format($net_amount, 2); $sub_total +=$net_amount; @endphp</td>
                </tr>
            @endforeach
        </table>

    @else

        <table class="custom-table  width-100">
            <tr>
                <th> S/N</th>
                <th> Item Description</th>
                <th> Total</th>
                <th> Discount</th>
                <th class="text-right">Net Amount</th>
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

                    <td class="text-right"> @php $net_amount = $item->net_amount-$discount; echo number_format($net_amount,2); $sub_total +=$net_amount @endphp</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
<table class="width-100 margin-top-10px">
    <tr>
        <td class="width-60 vertical-align-top"> @php echo  (!empty($sale_info->remarks)?"<b>Remarks:</b> ".$sale_info->remarks:'') @endphp</td>
        <td class="width-40">
            <table class="custom-table  width-100 ">
                <tr>
                    <th class="text-right width-40"> Sub Total</th>
                    <td class="text-right">  {{ number_format((float)$sub_total, 2)}}</td>
                </tr>
                <tr>
                    <th class="text-right"> Invoice Discount</th>
                    <td class="text-right">
                        @php  $invoice_discount = $sale_details_data[0]->invoice_discount; echo number_format((float)$invoice_discount, 2)  @endphp </td>
                </tr>
                <tr>
                    <th class="text-right"> Grand Total</th>
                    <td class="text-right">
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
            {{ (!empty($sale_info->userName)?$sale_info->userName:'') }}
            <div class="InviceFooterSign"><b>Issue By</b>  </div>
        </td>
    </tr>
</table>






