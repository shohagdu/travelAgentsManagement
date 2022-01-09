<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-10px"><br><br><br><br>
   <h3>Bank Name : {{ $data['data'][0]->bank_name}}</h3>
    
<?php
    $i=1;
    $balanceAmount='0.00';
?>

<table  class="custom-table  width-100">
    <thead>
        <tr>
            <th class="width-4">SL</th>
            <th class="width-12">Date</th>
            <th> Remarks </th>
            <th class="text-right paddingRight5px  width-12">Debit</th>
            <th class="text-right paddingRight5px width-12">Credit</th>
            <th class="text-right paddingRight5px  width-12">Balance</th>
        </tr>
    </thead>
    <tbody>
     @php $balance = 0; $dr_total = 0 ; $cr_total = 0; @endphp
    @if(!empty($data['data']))
        @foreach($data['data'] as $key=>$row)
        <tr>
            <td>{{ $i++ }}</td>
            <td nowrap=""> {{ (!empty($row->transaction_date)?date('d M, Y',strtotime($row->transaction_date)):'') }}</td>
            <td class="text-left">{{$row->remarks}} </td>
            <td> 
                @if ($row->type == 1)
                  {{ $row->amount}}
                  @php $dr = $row->amount;   $dr_total += $row->amount; @endphp
                @else
                @php $dr = 0;  @endphp
                @endif 
                </td>
              <td>   
                @if ($row->type == 2)
                {{ $row->amount}}
                @php $cr =  $row->amount;  $cr_total += $row->amount; @endphp
                @else
                @php $cr = 0;  @endphp
                @endif  
              </td>
              <td> 
                @php
                 echo  $balance = $balance + ( $cr - $dr) ;
                @endphp 
              </td>
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





