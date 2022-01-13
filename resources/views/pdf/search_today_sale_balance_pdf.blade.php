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
            <td> <h4> Today Sale Balance List  </h4> </td>
            <td class="width-13" ><span style="text-align: right; float: right;"> From Date: {{date('d-M-Y', strtotime($from_date))}} To Date: {{date('d-M-Y', strtotime($to_date))}}  </span> </td>
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
      <td  class="text-right"> {{ number_format((float) $item->sale_amount, 2 )}}</td>
      <td  class="text-right"> {{ number_format((float) $item->discount, 2 )}}</td>
      <td  class="text-right">@php  echo number_format((float) $item->amount, 2); $total_amount += $item->amount;  @endphp</td>
    </tr>
    @endforeach
    <tr>
      <th  class="text-right" colspan="5"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
      <th  class="text-right">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
    </tr>
    @else
        <tr>
            <td colspan="6" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





