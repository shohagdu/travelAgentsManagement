<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleCategory;
use App\Models\Bank;
use App\Models\AgentRecord;
use App\Models\AccTransactionInfo;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use PDF;

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
        $currentDueAmount     = $this->sale_model->currentDueAmount();

        return view('dashboard', compact(
                                'today_sale_balance',
                                'today_credit_balance',
                                'today_debit_balance',
                                'total_agent',
                                'todayTransaction',
                                'currentDueAmount',
        ));
    }

    // today sale balance
    public function today_sale_balance_view(){
        $sale_category_info = SaleCategory::take(7)->get();
        $today_sale_balance = $this->sale_model->today_sale_balance();

        return view('dashboard_view.today_sale_balance_view', compact('sale_category_info','today_sale_balance'));
    }
    public function searchTodaySaleBalanceBtnAction(Request $request)
    {
        $sale_category_id    = (!empty($request->sale_category_id) ? $request->sale_category_id : '');
        $today_sale_balance  = $this->sale_model->search_today_sale_balance($sale_category_id);

        return view('dashboard_view.today_sale_balance_view_search', compact('today_sale_balance','sale_category_id'));
    }
    public function search_today_sale_balance_pdf($sale_category_id) {
        $organization_info  = OrganizationSetup::first();
        $today_sale_balance  = $this->sale_model->search_today_sale_balance($sale_category_id);

        $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
            $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
            $mpdf->SetWatermarkImage(
                asset('public/assets/images/'.$organization_info->logo) . "", .1,
                array(70, 20),
                array(77, 150)
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle('Today Sale list');
            $page_footer_html = view()->make('pdf.pdfHeader', ['organization_info'=>$organization_info])->render();

            $mpdf->SetHTMLHeader($page_footer_html);

            $pagefooter="If you have any question, please contact ".(!empty($organization_info->mobile)?" Mobile:".$organization_info->mobile:'').(!empty($organization_info->email)?", Email: ".$organization_info->email:'').". Printed Date:".date('d M, Y');
            $mpdf->SetHTMLFooter("<div style='text-align: center;font-size:10px;color:gray;'>".$pagefooter." || Page No: {PAGENO} of {nb}</div>");

            $margin_left   = 5;
            $margin_right  = 5;
            $margin_top    = 10;
            $margin_bottom = 5;
            $paper_type    = 'a4';

            $mpdf->AddPage('P', '', '', '', '', $margin_left, $margin_right, $margin_top, $margin_bottom, 5, 5, '', '', '', '', '', '', '', '', '', $paper_type);
            }];

        $pdf = PDF::loadHtml(view('pdf.search_today_sale_balance_pdf', compact('today_sale_balance')), $config);

        return $pdf->stream('TodaySaleBalance.pdf');
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

    //  due list view 
    public function due_list_view(){
        $agent_info = AgentRecord::all();
        $due_list_view = $this->sale_model->due_list_view();
        return view('dashboard_view.due_list_view', compact('agent_info','due_list_view'));
    }
    public function agent_due_balance_view(Request $request){
        $agent_info = AgentRecord::all();
        $agent_id = $request->agent_id;
        $due_list_view = $this->sale_model->agent_due_balance_view($agent_id);
        return view('dashboard_view.due_list_view', compact('agent_info','due_list_view'));
    }
    //  advance list view 
    public function advance_list_view(){
        $agent_info = AgentRecord::all();
        $advance_list_view = $this->sale_model->due_list_view();
        return view('dashboard_view.advance_list_view', compact('agent_info','advance_list_view'));
    }
    public function agent_advance_balance_view(Request $request){
        $agent_info = AgentRecord::all();
        $agent_id = $request->agent_id;
        $advance_list_view = $this->sale_model->agent_due_balance_view($agent_id);

        // echo "<pre>";
        // print_r($advance_list_view);exit;
        return view('dashboard_view.advance_list_view', compact('agent_info','advance_list_view'));
    }

    // Due Statement
    public function due_statement(){
        $today_sale_balance = $this->sale_model->today_sale_balance();
        return view('dashboard_view.due_statement', compact('today_sale_balance'));
    }
}
