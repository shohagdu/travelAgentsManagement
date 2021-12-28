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
        $this->transaction_model = new AccTransactionInfo();
	}
    public function index()
    {
        $param['from_date']   = date('Y-m-d');
        $today_sale_balance   = DB::table('acc_transaction_infos')->select('debit_amount')->where('trans_type', 1)->where('trans_date', date('Y-m-d'))->sum('debit_amount');
        $today_credit_balance = DB::table('acc_transaction_infos')->select('credit_amount')->where('trans_type', 2)->where('trans_date', date('Y-m-d'))->sum('credit_amount');
        $today_debit_balance  = DB::table('acc_transaction_infos')->select('debit_amount')->where('trans_type', 3)->where('trans_date', date('Y-m-d'))->sum('debit_amount');
        $total_agent          = AgentRecord::where('is_active','=', 1)->count();

        $todayTransaction     = '0.00';
        $todayTransactionCr   = $this->transaction_model->balanceSum($param,'credit_amount');
        $todayTransactionDr   = $this->transaction_model->balanceSum($param,'debit_amount');
        $todayTransaction     = ($todayTransactionDr-$todayTransactionCr);

        return view('dashboard', compact(
                                'today_sale_balance',
                                'today_credit_balance',
                                'today_debit_balance',
                                'total_agent',
                                'todayTransaction'
        ));
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
    // today debit balance
    public function today_debit_balance_view(){
        $today_debit_balance = $this->sale_model->today_debit_balance();

        return view('dashboard_view.today_debit_balance_view', compact('today_debit_balance'));
    }

    // today due list
    public function due_list_view(){
        $due_list_view = $this->sale_model->due_list_view();
//         echo "<pre>";
//         print_r($due_list_view);
//         exit;
        return view('dashboard_view.due_list_view', compact('due_list_view'));
    }

    // Due Statement
    public function due_statement(){
        $today_sale_balance = $this->sale_model->today_sale_balance();
        return view('dashboard_view.due_statement', compact('today_sale_balance'));
    }
}
