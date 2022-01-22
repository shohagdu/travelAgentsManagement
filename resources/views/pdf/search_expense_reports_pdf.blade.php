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
            <td> <h4> Expense Reports</h4> </td>
            <td class="width-13" ><span style="text-align: right; float: right;"> From Date: {{date('d-M-Y', strtotime($from_date))}} To Date: {{date('d-M-Y', strtotime($to_date))}}  </span> </td>
        </tr>
    </table>
</div>
<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-16">Category Name</th>
            <th class="text-right paddingRight5px  width-12">Date</th>
            <th> Remarks </th>
            <th class="text-right paddingRight5px width-12">Amount</th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($expense_balance))
    @php $i=1; $total_amount=0; @endphp
    @foreach ($expense_balance as $item )
        
    <tr>
      <td>{{ $i++}}</td>
      <td>{{ $item->title}}</td>
      <td class="text-left">{{date("d-m-Y", strtotime($item->date))}}</td>
      <td>{{ $item->remarks}}</td>
      <td  class="text-right">@php  echo number_format((float) $item->amount, 2); $total_amount += $item->amount;  @endphp</td>
    </tr>
    @endforeach
    <tr>
      <th  class="text-right" colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
      <th  class="text-right">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
    </tr>
    @else
        <tr>
            <td colspan="4" class="text-center"> Please Select Filter Information</td>
        </tr>
    @endif

    </tbody>
</table>

</div>





