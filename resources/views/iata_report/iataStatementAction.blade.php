<?php
    $i=1;
    $balanceAmount='0.00';
?>
<a style="float: right; margin-bottom: 5px;"  target="_blank" href="iata_statement_pdf/{{ (!empty($param_info['from_date'])?$param_info['from_date']:'0000-00-00') }}/{{ (!empty($param_info['to_date'])?$param_info['to_date']:'0000-00-00') }}" class="btn btn-warning btn-sm text-white "> <i class="mdi mdi-printer"></i>  Print  </a><br>
<table  class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Remarks</th>
            <th>Type</th>
            <th class="text-end">Sale Amount </th>
            <th class="text-end">Debit Amount </th>
            <th class="text-end">Credit Amount </th>
        </tr>
    </thead>
    <tbody>
    @php $sale_total = 0; $dr_total = 0 ; $cr_total = 0; @endphp
    @if(!empty($record['data']))
        @foreach($record['data'] as $key=>$row)
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
                <td class="text-end"> 
                    @if ($row->type == 1)
                      {{number_format((float) $row->amount, 2)}}
                      @php $sale = $row->amount;   $sale_total += $row->amount; @endphp
                    @else
                    @php echo $sale = number_format((float) 0, 2);  @endphp
                    @endif 
                </td>
                <td class="text-end">   
                    @if ($row->type == 2)
                    {{number_format((float) $row->amount, 2)}}
                    @php $dr = $row->amount;   $dr_total += $row->amount; @endphp
                    @else
                    @php echo $dr = number_format((float) 0, 2);  @endphp
                    @endif 
                </td>
                <td class="text-end">   
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
            <td colspan="6" class="text-center">Please Select Filter Information</td>
        </tr>
    @endif


    </tbody>
</table>
