<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\AgentRecord;
use App\Models\AccTransactionInfo;
use Illuminate\Support\Facades\Auth;
use Session;


class BillCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank         = Bank::all();
        $agent_info   = AgentRecord::all();

        return view('bill_collection.bill', compact('bank','agent_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id'   => ['required'],
            'due_amount' => ['required'],
            'trans_date' => ['required'],
        ]);

        // transaction data
        $transaction_data = new  AccTransactionInfo();
            
        $transaction_data->debit_acc         = isset($request->bank_name) ? $request->bank_name : 0;
        $transaction_data->credit_acc        = $request->agent_id;
        $transaction_data->debit_amount      = 0.00;
        $transaction_data->credit_amount     = $request->payment_amount;
        $transaction_data->payment_method    = $request->payment_method;
        $transaction_data->receipt_cheque_no = $request->receipt_cheque_no;
        $transaction_data->remarks           = $request->remarks;
        $transaction_data->trans_type        = 2;
        $transaction_data->is_active         = 1;
        $transaction_data->trans_date        = date('Y-m-d');
        $transaction_data->created_by        = Auth::user()->id;
        $transaction_data->created_ip        = request()->ip();
        $transaction_data->created_at        = date('Y-m-d H:i:s');
        // echo "<pre>";
        // print_r($transaction_data);exit;

        $transaction_save = $transaction_data->save();

        if($transaction_save){
            return redirect()->route('bill-collection')->with('flash.message', 'Bill Sucessfully Saved!')->with('flash.class', 'success');
        }else{
            return redirect()->route('bill-collection')->with('flash.message', 'Somthing went to wrong!')->with('flash.class', 'danger');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
