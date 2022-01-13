<?php
    $i=1;
    $balanceAmount='0.00';
?>
<a style="float: right; margin-bottom: 5px;"  target="_blank" href="bank_statement_pdf/{{ $param_info['bank_id'] }}/{{ (!empty($param_info['from_date'])?$param_info['from_date']:'0000-00-00') }}/{{ (!empty($param_info['to_date'])?$param_info['to_date']:'0000-00-00') }}" class="btn btn-warning btn-sm text-white "> <i class="mdi mdi-printer"></i>  Print  </a><br>
<table  class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Remarks</th>
            <th class="text-end">Debit</th>
            <th class="text-end">Credit</th>
            <th class="text-end">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php $balance = 0; $dr_total = 0 ; $cr_total = 0; @endphp
{{--    {{ dd($record['data']) }}--}}
    @if(!empty($record['data']))
        @foreach($record['data'] as $key=>$row)
            <tr>
                <td>{{ $i++ }}</td>
                <td nowrap=""> {{ (!empty($row->transaction_date)?date('d M, Y',strtotime($row->transaction_date)):'') }}</td>
                <td class="text-left">{{$row->remarks}} </td>
                <td class="text-end"> 
                    @if ($row->type == 1)
                    {{number_format((float) $row->amount, 2)}}
                      @php $dr = $row->amount;   $dr_total += $row->amount; @endphp
                    @else
                    @php $dr = 0;  @endphp
                    @endif 
                    </td>
                  <td class="text-end">   
                    @if ($row->type == 2)
                    {{number_format((float) $row->amount, 2)}}
                    @php $cr =  $row->amount;  $cr_total += $row->amount; @endphp
                    @else
                    @php $cr = 0;  @endphp
                    @endif  
                  </td>
                  <td class="text-end"> 
                    @php $balance = $balance + ( $cr - $dr) ;@endphp 
                    {{number_format((float) $balance, 2)}}
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
