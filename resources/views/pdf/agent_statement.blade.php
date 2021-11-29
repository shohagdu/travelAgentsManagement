<style>
    body {
        font-family: 'bangla',Verdana, Arial, sans-serif;
        font-size: 13px;
    }
</style>
<link rel="stylesheet" href="{{ asset('public/css/invoice.css')}}">

<div class="row margin-top-10px"><br><br><br><br>
    <table class="custom-table  width-50 table">
        <tr>
            <th> Agent Name</th>
            <td> {{$agent_info->name}}</td>
        </tr>
        <tr>
            <th> Address </th>
            <td>  {{$agent_info->address}}</td>
        </tr>
        <tr>
            <th> Duration </th>
            <td>  {{date('d-m-Y', strtotime($frist_date))}} to {{date('d-m-Y', strtotime($last_date))}}  </td>
        </tr>
    </table><br>

    <table class="custom-table  width-100 table" rules="all">
        <tr>
            <th class="width-10">SL</th>
            <th class="width-10">Date </th>
            <th >Transaction Details </th>
            <th class="text-center">Debit </th>
            <th class="text-center">Credit </th>
            <th class="text-center">Balance </th>
        </tr>
        @php $i=1;  $balance = 0; $dr_total = 0 ; $cr_total = 0; @endphp
        @foreach($transaction_info as $item )
            <tr>
                <td>{{$i++}}</td>
                <td>{{ date('d M, Y', strtotime($item->trans_date))}}</td>
                <td>
                    @if($item->trans_type==1) Sale @elseif($item->trans_type ==2) Credit Bill @elseif($item->trans_type ==3) Debit Bill @endif
                    @if($item->account_name !='') ({{$item->account_name}}) @endif
                     {{ (!empty($item->remarks)?" >> ".$item->remarks:'') }}
                </td>
                <td class="text-end">
                    <?php
                        if($item->trans_type ==1 || $item->trans_type ==3 ){
                            $dr = $item->debit_amount; echo $dr;
                            $dr_total += $item->debit_amount ;
                        }else{
                            $dr = '0.00';
                            echo '-';
                        }
                    ?>
                </td>
                <td class="text-end">
                    <?php
                        if($item->trans_type ==2){
                            $cr = $item->credit_amount;
                            echo !empty($cr)?$cr:'0.00';
                            $cr_total += $item->credit_amount;
                        }else{
                            $cr  = '0.00';
                            echo '-';
                        }
                    ?>
                </td>
                <td class="text-end">@php   $balance = $balance + ($dr - $cr) ; echo (!empty($balance)?number_format($balance,2):'0.00') @endphp </td>
            </tr>
        @endforeach
        <tr>
            <th colspan="3"> <span class="SalatemtTotal"> Total</span></th>
            <th class="text-end"> {{ $dr_total}}</th>
            <th class="text-end"> {{ $cr_total}}</th>
            <th class="text-end"> {{ number_format($dr_total-$cr_total,2) }}</th>
        </tr>      
    </table>
</div>            





