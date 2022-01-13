<a style="float: right; margin-bottom: 5px;"  target="_blank" href="search_today_sale_balance_pdf/{{ $param_info['sale_category_id'] }}/{{ $param_info['from_date']}}/{{ $param_info['to_date']}}" class="btn btn-warning btn-sm text-white "> <i class="mdi mdi-printer"></i>  Print  </a><br>
<table class="TodaySaleBalanceTbl">
    <thead>
      <tr>
        <th scope="col">Sl</th>
        <th scope="col">Agent Name</th>
        <th scope="col">Sale Category</th>
        <th scope="col">Net Amount</th>
        <th scope="col">Discount</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
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
      <td class="text-end">{{ number_format((float) $item->sale_amount, 2 )}}</td>
      <td class="text-end"> {{ number_format((float) $item->discount, 2 )}}</td>
      <td class="text-end">@php  echo number_format((float) $item->amount, 2); $total_amount += $item->amount;  @endphp</td>
    </tr>
    @endforeach
    <tr>
      <th class="text-end" colspan="5"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
      <th class="text-end">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
    </tr>
  </table>