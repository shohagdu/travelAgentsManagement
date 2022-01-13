@extends('layouts.master')
@section('title', 'Today Sale Balance')
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form method="post" id="todaySaleBalanceForm"  action="javascript:void(0)" >
          <?php echo csrf_field(); ?>
          <div class="form-group row">
            <div class="col-sm-3"><br><h5>Today Sale Balance</h5></div>
                  <div class="col-sm-3">
                    <label> Sale Categoy </label>
                    <select name="sale_category_id" id="sale_category_id"
                    class="form-control">
                      <option value=""> Select</option>
                      @foreach($sale_category_info as $item)
                          <option value="{{$item->id}}"> {{$item->title}} </option>
                      @endforeach
                  </select>
                </div>
                <div class="col-sm-2">
                  <label> From Date </label>
                  <input type="text" class="form-control" name="from_date" id="from_date" placeholder="dd-mm-yyyy" autocomplete="off">
              </div>
              <div class="col-sm-2">
                  <label> To Date </label>
                  <input type="text" class="form-control" name="to_date" id="to_date" placeholder="dd-mm-yyyy" autocomplete="off">
              </div>
             
              <div class="col-sm-2">
                  <br>
                      <button type="button" onclick="searchTodaySaleBalanceBtn()"  id="searchTodaySaleBalance"
                              class="btn btn-success text-white"><i class="mdi mdi-account-search"></i>Search
                      </button>
              </div>
          </div>
      </form>
      
      <table class="TodaySaleBalanceTbl showReportsHide " >
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
          <td class="text-end">{{ $item->sale_amount}}</td>
          <td class="text-end">{{ $item->discount}}</td>
          <td class="text-end">@php  echo $item->amount; $total_amount += $item->amount;  @endphp</td>
        </tr>
        @endforeach
        <tr>
          <th class="text-end" colspan="5"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
          <th class="text-end">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
        </tr>
      </table>

      <div class="showReportsToday">

      </div>
    </div>
    
  </div>
</div>
</div>
@endsection
@section('js')
<script src="{{ asset('public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('public/js/global.js')}}"></script>
@endsection