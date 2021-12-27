<?php
$i=1;
$balance='0.00';
?>
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
                <td>{{ (!empty($getTransType[$row->trans_type])?$getTransType[$row->trans_type]:'') }}

                    {{ (!empty($row->remarks)?" >> ".$row->remarks:'') }}
                    {{ (!empty($row->invoice_no)?" >> Inv. # ".$row->invoice_no:'') }}
                    {{ (!empty($row->receipt_cheque_no)?" >> Cheque # ".$row->receipt_cheque_no:'') }}
                    {{ (!empty($row->reference_number)?" >> Ref. No# ".$row->reference_number:'') }}
                </td>
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
