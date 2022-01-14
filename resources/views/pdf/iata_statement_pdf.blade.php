<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-10px">
<div class="pdf-heading">IATA Statement</div>
<?php
    $i=1;
    $balanceAmount='0.00';
?>

<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-12">Date</th>
            <th> Remarks </th>
            <th class="text-center paddingRight5px  width-7" >Type</th>
            <th class="text-right paddingRight5px  width-10">Sales </th>
            <th class="text-right paddingRight5px  width-10">Debit  </th>
            <th class="text-right paddingRight5px width-10">Credit  </th>
            <th class="text-right paddingRight5px width-10">Balance </th>
        </tr>
    </thead>
    <tbody>
     @php $sale_total = 0; $dr_total = 0 ; $cr_total = 0; $tBalance=0; @endphp
    @if(!empty($data['data']))
        @foreach($data['data'] as $key=>$row)
        <tr>
            <td>{{ $i++ }}</td>
            <td nowrap=""> {{ (!empty($row->date)?date('d M, Y',strtotime($row->date)):'') }}</td>
            <td class="text-left">{{$row->remarks}} </td>
            <td class="text-center-invoice">
                @if($row->type == 1)
                    Sale
                @elseif($row->type == 2)
                    Debit
                @elseif($row->type == 3)
                    Credit
                @endif

            </td>
            <td class="text-right paddingRight5px">
                @if ($row->type == 1)
                  {{number_format((float) $row->amount, 2)}}
                  @php $sale = $row->amount;   $sale_total += $row->amount; @endphp
                @else
                @php echo $sale = number_format((float) 0, 2);  @endphp
                @endif
            </td>
            <td class="text-right paddingRight5px">
                @if ($row->type == 2)
                {{number_format((float) $row->amount, 2)}}
                @php $dr = $row->amount;   $dr_total += $row->amount; @endphp
                @else
                @php echo $dr = number_format((float) 0, 2);  @endphp
                @endif
            </td>
            <td class="text-right paddingRight5px">
                @if ($row->type == 3)
                {{number_format((float) $row->amount, 2)}}
                @php $cr =  $row->amount;  $cr_total += $row->amount; @endphp
                @else
                @php  echo $cr = number_format((float) 0, 2);  @endphp
                @endif
            </td>
            <td class="text-right paddingRight5px">
                @php  echo number_format( $tBalance += (($sale+$dr) - $cr),2)   @endphp
            </td>

        </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right paddingRight5px"> Total </td>
            <td class="text-right paddingRight5px">
                {{number_format((float) $sale_total, 2)}}
            </td>
            <td class="text-right paddingRight5px ">
                {{number_format((float) $dr_total, 2)}}
            </td>
            <td class="text-right paddingRight5px ">
                {{number_format((float) $cr_total, 2)}}
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"> Balance </td>
            <td style="text-align: center" colspan="4">
                @php $balance = (($sale_total+$dr_total) - $cr_total ) @endphp
                {{number_format((float) $balance, 2)}}
            </td>
        </tr>
    @else
        <tr>
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





