<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-10px"><br><br><br><br>
    <table class="custom-table  width-100" style="float: right">
        <tr>
            <td class="width-10"> Agent Name</td>
            <td class="width-40"> {{$agent_info->name}}</td>
            <td rowspan="3" style="text-align: center;border-top: 1px solid #fff;border-right: 1px solid #fff;border-bottom: 1px solid #fff;"><h1>Agent Date Wise Statement</h1>  </td>
        </tr>
        <tr>
            <td> Address </td>
            <td>  {{$agent_info->address}}</td>
        </tr>
        <tr>
            <td> Duration </td>
            <td>  {{date('d-m-Y', strtotime($from_date))}} to {{date('d-m-Y', strtotime($to_date))}}  </td>
        </tr>
    </table>
    <br/>
    

<?php
    $i=1;
    $balanceAmount='0.00';
?>

<table  class="custom-table  width-100">
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
    <tr>
        <td style="text-align: center" colspan="5"> Carry over head balance &nbsp; </td>
        <td class="text-end"> {{ $balance}} </td>
    </tr>
    <tbody>

    @if(!empty($data['data']))
        @foreach($data['data'] as $key=>$row)
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
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





