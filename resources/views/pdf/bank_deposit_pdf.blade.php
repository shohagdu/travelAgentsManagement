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
            <td> <h3>Bank Deposit </h3> </td>
            <td><span style="text-align: right; float: right;"> Date: {{date('d-M-Y')}}</span> </td>
        </tr>
    </table>
</div>
<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-16">Bank Name</th>
            <th> Account No </th>
            <th class="text-right paddingRight5px  width-12">Branch Name</th>
            <th class="text-right paddingRight5px  width-12">Amount</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($bank_deposit_data))
    @php $i=1; $total_amount=0; @endphp
    @foreach ($bank_deposit_data as $item )
        
    <tr>
      <td>{{ $i++}}</td>
      <td>{{ $item->name_name}}</td>
      <td>{{ $item->account_no}}</td>
      <td>{{ $item->branch_name}}</td>
      <td class="text-right width-20"> {{ !empty($item->credit_amount-$item->debit_amount)?number_format($item->credit_amount-$item->debit_amount,2):'0.00' }}  @php  $total_amount+=($item->credit_amount-$item->debit_amount); @endphp </td>
    </tr>
    @endforeach
    <tr>
      <th colspan="4"> <span class="TotalTextSpan "> Total &nbsp;</span></th>
      <th class="text-right">  &nbsp; <b>  {{ number_format((float)$total_amount, 2, '.', '')}} </b> </th>
    </tr>
    @else
        <tr>
            <td colspan="5" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





