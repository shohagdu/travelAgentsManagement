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
            <td> <h4>Today Sale Balance List  </h4> </td>
            <td class="width-13" ><span style="text-align: right; float: right;"> Date: {{date('d-M-Y')}}</span> </td>
        </tr>
    </table>
</div>
<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-16">Agent Name</th>
            <th> Sale Category </th>
            <th class="text-right paddingRight5px  width-12">Net Amount</th>
            <th class="text-right paddingRight5px width-12">Discount</th>
            <th class="text-right paddingRight5px  width-12">Total</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($today_sale_balance))
    @php $i=1; $total_amount=0; @endphp
    @foreach ($today_sale_balance as $item )
        
    <tr>
      <td>{{ $i++}}</td>
      <td>{{ $item->agent_name}}</td>
      <td>
        @php
            if ($item->sale_category_id == 1) {
              echo "Flights";
            }elseif ($item->sale_category_id ==2 ) {
              echo "Hotels";
            }elseif ($item->sale_category_id ==3 ) {
              echo "Transfers";
            }elseif ($item->sale_category_id ==4 ) {
              echo "Activities";
            }elseif ($item->sale_category_id ==5 ) {
              echo "Holidays";
            }elseif ($item->sale_category_id ==6 ) {
              echo "Visa";
            }elseif ($item->sale_category_id ==7 ) {
              echo "Others";
            }else{
              echo "";
            }
        @endphp  
      </td>
      <td>{{ $item->sale_amount}}</td>
      <td>{{ $item->discount}}</td>
      <td>@php  echo $item->amount; $total_amount += $item->amount;  @endphp</td>
    </tr>
    @endforeach
    <tr>
      <th colspan="5"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
      <th>  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
    </tr>
    @else
        <tr>
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





