<?php
    $i=1;
    $balanceAmount='0.00';
?>
<table  class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Transaction Details</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
{{--    {{ dd($record['data']) }}--}}
    @if(!empty($record['data']))
        @foreach($record['data'] as $key=>$row)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ (!empty($row->trans_date)?date('d M, Y',strtotime($row->trans_date)):'') }}</td>
                <td>{{ (!empty($row->remarks)?$row->remarks:'') }}</td>
                <td class="text-end">{{ (!empty($row->debit_amount)?$row->debit_amount:'') }}</td>
                <td class="text-end">
                    {{ (!empty($row->credit_amount)?$row->credit_amount:'') }}
                </td>
                <td class="text-end">{{  number_format($balanceAmount +=  ( $row->debit_amount-$row->credit_amount),2,'.','') }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">Please Select Filter Information</td>
        </tr>
    @endif


    </tbody>
</table>
