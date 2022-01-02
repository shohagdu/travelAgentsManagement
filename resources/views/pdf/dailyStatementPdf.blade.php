<?php
$i=1;
$balance='0.00';
?>
<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-60px"><br><br><br><br><br>
    <table class="custom-table  width-100" style="float: right">
        <tr>
            <td> <h4> Today Balance Statement </h4> </td>
            <td ><span style="text-align: right; float: right;"> From Date: {{date('d-M-Y', strtotime($from_date))}} To Date: {{date('d-M-Y', strtotime($to_date))}}  </span> </td>
        </tr>
    </table>
</div>
<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-10">Date</th>
            <th>Transaction Details</th>
            <th class="text-right paddingRight5px  width-12">Debit</th>
            <th class="text-right paddingRight5px width-12">Credit</th>
            <th class="text-right paddingRight5px  width-12">Balance</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($data))
    @php
    $getTransType = getTransType();
    @endphp
    @php $i=1; $total_amount=0; @endphp
    @foreach($data as $key=>$row)
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
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





