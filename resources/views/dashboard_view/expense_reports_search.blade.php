<a style="float: right; margin-bottom: 5px;"  target="_blank" href="search_expense_reports_balance_pdf/{{ $param_info['expense_category_id'] }}/{{ $param_info['from_date']}}/{{ $param_info['to_date']}}" class="btn btn-warning btn-sm text-white "> <i class="mdi mdi-printer"></i>  Print  </a><br>
<table class="TodaySaleBalanceTbl">
    <thead>
      <tr>
        <th scope="col">Sl</th>
        <th scope="col">Expense Category</th>
        <th scope="col">Date</th>
        <th scope="col">Remarks</th>
        <th scope="col">Amount</th>
      </tr>
    </thead>
    @php $i=1; $total_amount=0; @endphp
    @foreach ($expense_balance as $item )
        
    <tr>
      <td>{{ $i++}}</td>
      <td>{{ $item->title}}</td>
      <td class="text-left">{{date("d-m-Y", strtotime($item->date))}}</td>
      <td>{{ $item->remarks}}</td>
      <td class="text-end">@php  echo number_format((float) $item->amount, 2); $total_amount += $item->amount;  @endphp</td>
    </tr>
    @endforeach
    <tr>
      <th class="text-end" colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
      <th class="text-end">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
    </tr>
  </table>