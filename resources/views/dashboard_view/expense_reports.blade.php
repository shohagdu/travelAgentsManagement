@extends('layouts.master')
@section('title', 'Expense Reports')
@section('main_content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form method="post" id="expenseReportBalanceForm"  action="javascript:void(0)" >
          <?php echo csrf_field(); ?>
          <div class="form-group row">
            <div class="col-sm-3"><br><h5>Expense Reports</h5></div>
                  <div class="col-sm-3">
                    <label> Expense Categoy </label>
                    <select name="expense_category_id" id="expense_category_id"
                    class="form-control">
                      <option value=""> Select</option>
                      @foreach($expense_category_info as $item)
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
                      <button type="button" onclick="searchExpenseReportBalanceBtn()"  id="searchExpenseReportBalance"
                              class="btn btn-success text-white"><i class="mdi mdi-account-search"></i>Search
                      </button>
              </div>
          </div>
      </form>
      
      <table class="TodaySaleBalanceTbl showReportsHide" >
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
          <td class="text-end">@php  echo $item->amount; $total_amount += $item->amount;  @endphp</td>
        </tr>
        @endforeach
        <tr>
          <th class="text-end" colspan="4"> <span class="TotalTextSpan"> Total &nbsp;</span></th>
          <th class="text-end">  &nbsp; {{ number_format((float)$total_amount, 2, '.', '')}} </th>
        </tr>
      </table>

      <div class="showReportsExpense">

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