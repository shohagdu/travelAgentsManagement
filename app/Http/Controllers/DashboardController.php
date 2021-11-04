<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Bank;
use App\Models\AgentRecord;
use App\Models\AccTransactionInfo;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today_total_sale       = DB::table('acc_transaction_infos')->select('debit_amount')->where('trans_type', 1)->where('trans_date', date('Y-m-d'))->sum('debit_amount');
        $today_total_collection = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 2)->where('trans_date', date('Y-m-d'))->sum('credit_amount');
        $today_total_refund     = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 3)->where('trans_date', date('Y-m-d'))->sum('credit_amount');
        $total_sale       = DB::table('acc_transaction_infos')->select('debit_amount')->where('trans_type', 1)->sum('debit_amount');
        $total_collection = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 2)->sum('credit_amount');
        $total_refund     = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 3)->sum('credit_amount');
        $total_agent      = AgentRecord::where('is_active','=', 1)->count();   

        return view('dashboard', compact('total_sale', 
                                'total_collection', 
                                'total_refund',
                                'today_total_sale',
                                'today_total_collection',
                                'today_total_refund',
                                'total_agent'));
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
        //
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
