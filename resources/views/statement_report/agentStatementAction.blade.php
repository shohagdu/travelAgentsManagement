<?php
    $i=1;
    $balanceAmount='0.00';
?>
<a style="float: right; margin-bottom: 5px;"  target="_blank" href="agent_date_wise_statement_pdf/{{ $param_info['agent_id'] }}/{{ (!empty($param_info['from_date'])?$param_info['from_date']:'0000-00-00') }}/{{ (!empty($param_info['to_date'])?$param_info['to_date']:'0000-00-00') }}" class="btn btn-warning btn-sm text-white "> <i class="mdi mdi-printer"></i>  Print  </a><br>
<table  class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Transaction Details</th>
            <th class="text-end">Debit</th>
            <th class="text-end">Credit</th>
            <th class="text-end">Balance</th>
        </tr>
    </thead>
    <tr>
        <td class="text-center" colspan="5"> Carry over head balance &nbsp; </td>
        <td class="text-end"> {{ number_format($balance,2,'.','')}} </td>
    </tr>
    <tbody>
    @php
        $getTransType = getTransType();
    @endphp
{{--    {{ dd($record['data']) }}--}}
    @if(!empty($record['data']))
        @foreach($record['data'] as $key=>$row)
            <tr>
                <td>{{ $i++ }}</td>
                <td nowrap="">{{ (!empty($row->trans_date)?date('d M, Y',strtotime($row->trans_date)):'') }}</td>
                <td>{{ (!empty($getTransType[$row->trans_type])?$getTransType[$row->trans_type]:'') }}{{ (!empty($row->remarks)?" <> ".$row->remarks:'') }}</td>
                <td class="text-end">{{ (!empty($row->debit_amount)?$row->debit_amount:'') }}</td>
                <td class="text-end">
                    {{ (!empty($row->credit_amount)?$row->credit_amount:'') }}
                </td>
                <td class="text-end">{{  number_format(($balance+=($row->debit_amount-$row->credit_amount)),2,'.','') }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">Please Select Filter Information</td>
        </tr>
    @endif


    </tbody>
</table>
