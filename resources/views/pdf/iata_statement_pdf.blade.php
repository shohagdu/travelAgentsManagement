<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-10px"><br><br><br><br>
    
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
            <th class="text-center paddingRight5px  width-12">Type</th>
            <th class="text-right paddingRight5px  width-12">Sale Amount </th>
            <th class="text-right paddingRight5px  width-12">Debit Amount </th>
            <th class="text-right paddingRight5px width-12">Credit Amount </th>
        </tr>
    </thead>
    <tbody>
     @php $sale_total = 0; $dr_total = 0 ; $cr_total = 0; @endphp
    @if(!empty($data['data']))
        @foreach($data['data'] as $key=>$row)
        <tr>
            <td>{{ $i++ }}</td>
            <td nowrap=""> {{ (!empty($row->date)?date('d M, Y',strtotime($row->date)):'') }}</td>
            <td class="text-left">{{$row->remarks}} </td>
            <td class="text-center">
                @if($row->type == 1)
                    Sale
                @elseif($row->type == 2)
                    Debit
                @elseif($row->type == 3)
                    Credit
                @endif

            </td>
            <td class="text-right"> 
                @if ($row->type == 1)
                  {{number_format((float) $row->amount, 2)}}
                  @php $sale = $row->amount;   $sale_total += $row->amount; @endphp
                @else
                @php echo $sale = number_format((float) 0, 2);  @endphp
                @endif 
            </td>
            <td class="text-right">   
                @if ($row->type == 2)
                {{number_format((float) $row->amount, 2)}}
                @php $dr = $row->amount;   $dr_total += $row->amount; @endphp
                @else
                @php echo $dr = number_format((float) 0, 2);  @endphp
                @endif 
            </td>
            <td class="text-right">   
                @if ($row->type == 3)
                {{number_format((float) $row->amount, 2)}}
                @php $cr =  $row->amount;  $cr_total += $row->amount; @endphp
                @else
                @php  echo $cr = number_format((float) 0, 2);  @endphp
                @endif  
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





