<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\AgentRecord;
use App\Models\AccTransactionInfo;
use App\Models\OrganizationSetup;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use PDF;

class ReportController extends Controller
{
    public $transaction_model;

    public function __construct()
    {
        $this->middleware('auth');
        $this->transaction_model = new AccTransactionInfo();
    }

    public function index()
    {
        $agent_info = AgentRecord::all();

        return view('statement_report.statement_report', compact('agent_info'));
    }

    public function get_statement_report_data(Request $request)
    {
        header("Content-Type: application/json");
        $type = $request->type;
        $agent_id = $request->agent_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start' => $start,
            'limit' => $limit,
            'type' => $type,
            'agent_id' => $agent_id,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $response = $this->transaction_model->statement_report_list_data($request_data, $search_content);

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal'] = $count;
        $response['recordsFiltered'] = $count;
        $response['draw'] = $request->draw;

        echo json_encode($response);
    }

    public function agent_date_wise_statement()
    {
        $agent_info = AgentRecord::all();
        return view('statement_report.agent_date_wise_statement', compact('agent_info'));
    }

    public function get_agent_date_wise_statement_data(Request $request)
    {
        header("Content-Type: application/json");
        $agent_id = $request->agent_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $start = $request->start;
        $limit = $request->length;
        $search_content = ($request['search']['value'] != '') ? $request['search']['value'] : false;

        $request_data = [
            'start' => $start,
            'limit' => $limit,
            'agent_id' => $agent_id,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $response = $this->transaction_model->get_agent_date_wise_statement_data($request_data, $search_content);

        // echo "<pre>";
        // print_r($response);exit;

        $count = DB::select("SELECT FOUND_ROWS() as `row_count`")[0]->row_count;
        $response['recordsTotal'] = $count;
        $response['recordsFiltered'] = $count;
        $response['draw'] = $request->draw;

        echo json_encode($response);
    }

    public function agentStatementAction(Request $request)
    {
        $param['agent_id']    = (!empty($request->agent_id) ? $request->agent_id : '');
        $param['from_date']   = (!empty($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : '');
        $param['to_date']     = (!empty($request->to_date) ? date('Y-m-d', strtotime($request->to_date)) : '');

        if(!empty($param['from_date'])) {
            $agent_debit_balance = $this->transaction_model->AgentDebitBalance($param);
            $agent_credit_balance = $this->transaction_model->AgentCreditBalance($param);
            $balance = ($agent_debit_balance - $agent_credit_balance);
        }else{
            $balance=0;
        }
        $data                 = $this->transaction_model->searchAgentStatement($param);
        return view('statement_report.agentStatementAction', ['record'=>$data, 'balance' => $balance, 'param_info' => $param]);
    }

    public function agent_date_wise_statement_pdf($agent_id, $from_date=NULL, $to_date=NULL) {
        $organization_info  = OrganizationSetup::first();
        $agent_info         = AgentRecord::find($agent_id);
        $from_date          =(($from_date=='0000-00-00')?'':$from_date);
        $to_date          =(($to_date=='0000-00-00')?'':$to_date);

        if(!empty($agent_id)){
            $param['agent_id']=$agent_id;
        }else{
            echo "<h1>Agent ID is required</h1>";exit;
        }
        if(!empty($from_date)){
            $param['from_date']=$from_date;
        }
        if(!empty($to_date)){
            $param['to_date']=$to_date;
        }
        if(!empty($from_date)) {
            $agent_debit_balance = $this->transaction_model->AgentDebitBalance($param);
            $agent_credit_balance = $this->transaction_model->AgentCreditBalance($param);
            $balance = ($agent_debit_balance - $agent_credit_balance);
        }else{
            $balance=0;
        }

        $data                 = $this->transaction_model->searchAgentStatement($param);

        $config = ['instanceConfigurator' => function ($mpdf) use($organization_info) {
            $mpdf->SetWatermarkImage(asset('public/assets/images/'.$organization_info->logo));
            $mpdf->SetWatermarkImage(
                asset('public/assets/images/'.$organization_info->logo) . "", .1,
                array(70, 20),
                array(77, 150)
            );
            $mpdf->showWatermarkImage = true;
            $mpdf->SetTitle('Agent Date Wise Statement');
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

        $pdf = PDF::loadHtml(view('pdf.agent_date_wise_statement_pdf', compact('agent_info','balance', 'from_date','to_date','data')), $config);

        return $pdf->stream('AgentdateWiseStatement.pdf');
    }

    public function dailyStatement()
    {
        $param['from_date']   = (!empty($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d'));
        $param['to_date']     = (!empty($request->to_date) ? date('Y-m-d', strtotime($request->to_date)) : date('Y-m-d'));

        $data                 = $this->transaction_model->searchAgentStatement($param);
        return view('dashboard_view.due_statement', ['record'=>$data, 'param_info' => $param]);
    }
    public function dailyStatementAction(Request $request)
    {
        $param['from_date']   = (!empty($request->from_date) ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d'));
        $param['to_date']     = (!empty($request->to_date) ? date('Y-m-d', strtotime($request->to_date)) : date('Y-m-d'));

        $data                 = $this->transaction_model->searchAgentStatement($param);
        return view('dashboard_view.dailyStatementAction', ['record'=>$data, 'param_info' => $param]);
    }

}
