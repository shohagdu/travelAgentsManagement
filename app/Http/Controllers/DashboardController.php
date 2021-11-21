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
    public $sale_model;
	public function __construct()
	{
	    $this->middleware('auth');
        $this->sale_model = new Sale();
	}
    public function index()
    {
        $today_sale_balance       = DB::table('acc_transaction_infos')->select('debit_amount')->where('trans_type', 1)->where('trans_date', date('Y-m-d'))->sum('debit_amount');
        $today_collection_balance = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 2)->where('trans_date', date('Y-m-d'))->sum('credit_amount');
        $total_agent      = AgentRecord::where('is_active','=', 1)->count();   

        return view('dashboard', compact(
                                'today_sale_balance',
                                'today_collection_balance',
                                'total_agent'));
    }
    
    // today sale balance
    public function today_sale_balance_view(){
        $today_sale_balance = $this->sale_model->today_sale_balance();

        return view('dashboard_view.today_sale_balance_view', compact('today_sale_balance'));
    }
     // today credit balance
     public function today_credit_balance_view(){
        $today_credit_balance = $this->sale_model->today_credit_balance();

        return view('dashboard_view.today_credit_balance_view', compact('today_credit_balance'));
    }
}
