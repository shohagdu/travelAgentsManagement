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
        $agent_debit_balance  = $this->transaction_model->AgentDebitBalance($param);
        $agent_credit_balance = $this->transaction_model->AgentCreditBalance($param);
        $balance              = ($agent_debit_balance- $agent_credit_balance);
        $data                 = $this->transaction_model->searchAgentStatement($param);
        
        return view('statement_report.agentStatementAction', ['record'=>$data, 'balance' => $balance]);
    }

    public function agent_date_wise_statement_pdf($id) {
       
    }
}
