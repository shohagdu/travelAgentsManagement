<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class AccTransactionInfo extends Model
{
    use HasFactory;

    public function bill_collection_list_data($receive, $search_content)
    {
    	$query = DB::table("acc_transaction_infos AS TRNS")
    	    ->join('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.trans_date', 'TRNS.remarks',  'AGRD.name as agent_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('TRNS.trans_type','=', 2)
            ->orderBy('TRNS.id', 'DESC');

        if($search_content != false){
            $query->Where("AGRD.name", "LIKE", $search_content)
                    ->orWhere("AGRD.name", "LIKE", $search_content);
        }

        if($receive['agent_id'] !=''){
                $query->Where("TRNS.credit_acc", "=", $receive['agent_id']);
            }
        if($receive['trans_date'] !=''){
            $query->Where("TRNS.trans_date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->paymentDate = date('d-m-Y', strtotime($row->trans_date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function debit_bill_list_data($receive, $search_content)
    {
    	$query = DB::table("acc_transaction_infos AS TRNS")
    	    ->join('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.debit_acc');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.debit_amount','TRNS.trans_date', 'TRNS.remarks',  'AGRD.name as agent_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('TRNS.trans_type','=', 3)
            ->orderBy('TRNS.id', 'DESC');

        if($search_content != false){
            $query->Where("AGRD.name", "LIKE", $search_content)
                    ->orWhere("AGRD.name", "LIKE", $search_content);
        }

        if($receive['agent_id'] !=''){
                $query->Where("TRNS.debit_acc", "=", $receive['agent_id']);
            }
        if($receive['trans_date'] !=''){
            $query->Where("TRNS.trans_date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->paymentDate = date('d-m-Y', strtotime($row->trans_date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function bill_refund_list_data($receive, $search_content)
    {
    	$query = DB::table("acc_transaction_infos AS TRNS")
    	    ->join('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.trans_date', 'TRNS.remarks',  'AGRD.name as agent_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('TRNS.trans_type', '=', 4)
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("AGRD.name", "LIKE", $search_content)
                    ->orWhere("AGRD.name", "LIKE", $search_content);
        }

        if($receive['agent_id'] !=''){
                $query->Where("TRNS.credit_acc", "=", $receive['agent_id']);
            }
        if($receive['trans_date'] !=''){
            $query->Where("TRNS.trans_date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $data['data'] = $query->get();

        return $data;
    }

    public function statement_report_list_data($receive, $search_content)
    {
        $type      = $receive['type'];
        $from_date = date('Y-m-d', strtotime($receive['from_date']));
        $to_date   = date('Y-m-d', strtotime($receive['to_date']));
    	$query = DB::table("acc_transaction_infos AS TRNS")
    	    ->leftJoin('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');

             })
             ->leftJoin('agent_records AS AGRD2', function($join){
                $join->on('AGRD2.id', '=', 'TRNS.debit_acc');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.debit_amount','TRNS.trans_date', 'TRNS.remarks','AGRD.name as agent_name','AGRD2.name as agent_name2')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("TRNS.trans_type", "LIKE", $search_content)
                    ->orWhere("TRNS.trans_type", "LIKE", $search_content);
        }
        if($receive['type'] !=''){
                $query->Where("TRNS.trans_type", "=", $receive['type']);
        }
        if($receive['agent_id'] !=''){
            $query->Where("TRNS.credit_acc", "=", $receive['agent_id'])
            ->orWhere("TRNS.debit_acc", "=", $receive['agent_id']);
        }
        if($receive['from_date'] !='' || $receive['to_date'] !=''){
            $query->whereBetween("TRNS.trans_date", [$from_date, $to_date]);
         }

        $data['data'] = $query->get();

        return $data;
    }

    // account report data
    public function account_report_list_data($receive, $search_content)
    {
        $from_date = date('Y-m-d', strtotime($receive['from_date']));
        $to_date   = date('Y-m-d', strtotime($receive['to_date']));
    	$query = DB::table("acc_transaction_infos AS TRNS")
    	    ->leftJoin('banks AS ACC', function($join){
                $join->on('ACC.id', '=', 'TRNS.debit_acc');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'), 'TRNS.credit_amount','TRNS.trans_date', 'TRNS.remarks','ACC.name as account_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->whereNotNull('TRNS.debit_acc')
            ->where('TRNS.trans_type', '!=', 1 )
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("ACC.name", "LIKE", $search_content);
        }
        if($receive['account_id'] !=''){
            $query->Where("TRNS.debit_acc", "=", $receive['account_id']);
        }
        if($receive['from_date'] !='' || $receive['to_date'] !=''){
            $query->whereBetween("TRNS.trans_date", [$from_date, $to_date]);
         }

        $data['data'] = $query->get();

        return $data;
    }

    // agent date wise statement
    public function get_agent_date_wise_statement_data($receive, $search_content)
    {
        $from_date = date('Y-m-d', strtotime($receive['from_date']));
        $to_date   = date('Y-m-d', strtotime($receive['to_date']));
        $id        =  $receive['agent_id'];

    	$query  = DB::table("acc_transaction_infos AS TRNS")
                    ->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'), 'TRNS.trans_type','TRNS.trans_date','TRNS.reference_number','TRNS.remarks as transRemark','TRNS.debit_amount','TRNS.credit_amount','ACC.name as account_name','sales.invoice_no','sales.remarks','sales.remarks as invRemarks', 'AGNT.name as agent_name', 'AGNT2.name as agent_name2', 'CTG.title as category_name')
                    ->leftJoin('banks AS ACC', function($join){
                        $join->on('ACC.id', '=', 'TRNS.debit_acc');
                    })
                    ->leftJoin('sales', function($join){
                        $join->on('sales.id', '=', 'TRNS.sales_id');
                    })
                    ->leftJoin('sale_categories AS CTG', function($join){
                        $join->on('CTG.id', '=', 'sales.sale_category_id');
                    })
                    ->leftJoin('agent_records AS AGNT', function($join){
                        $join->on('AGNT.id', '=', 'TRNS.credit_acc');
                    })
                    ->leftJoin('agent_records AS AGNT2', function($join){
                        $join->on('AGNT2.id', '=', 'TRNS.debit_acc');
                    })
                    ->where('TRNS.trans_type', '!=',4)
                    ->offset($receive['start'])
                    ->limit($receive['limit'])
                    //->orderBy('TRNS.trans_type', 'ASC')
                    ->orderBy('TRNS.id', 'DESC');

                    if($search_content != false){
                        $query->Where("TRNS.agent_id", "LIKE", $search_content)
                                ->orWhere("TRNS.agent_id", "LIKE", $search_content);
                    }

                    if($receive['agent_id'] !=''){
                        $query->where('TRNS.debit_acc', '=' , $id)
                              ->orWhere('TRNS.credit_acc', '=', $id);
                    }
                    if($receive['from_date'] !='' || $receive['to_date'] !=''){
                        $query->whereBetween("TRNS.trans_date", [$from_date, $to_date]);
                    }

                    $data['data'] = $query->get();

                    return $data;
    }

    public function searchAgentStatement($receive)
    {
        $query = DB::table("acc_transaction_infos AS TRNS")
            ->leftJoin('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');

            })
            ->leftJoin('agent_records AS AGRD2', function($join){
                $join->on('AGRD2.id', '=', 'TRNS.debit_acc');

            })
            ->leftJoin('sales', function($join){
                $join->on('sales.id', '=', 'TRNS.sales_id');
            })
            ->where('TRNS.is_active',1)
            ->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.trans_type','TRNS.debit_amount','TRNS.trans_date', 'TRNS.remarks','AGRD.name as agent_name','AGRD2.name as agent_name2','TRNS.reference_number','TRNS.remarks','TRNS.receipt_cheque_no','sales.invoice_no')
            ->orderBy('trans_date', 'ASC')->orderBy('id', 'ASC');

        if(!empty($receive['agent_id'])){
            $query->Where(function ($query) use ($receive) {
                $query->orWhere('TRNS.credit_acc', '=' , $receive['agent_id']);
                $query->orWhere('TRNS.debit_acc', '=' , $receive['agent_id']);
            });
        }
        if(!empty($receive['from_date']) && !empty($receive['to_date'])){
            $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['to_date']]);

        }
        // elseif($receive['from_date'] !='' && $receive['to_date'] ==''){
        //     $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['from_date']]);
        // }

        $data['data'] = $query->get();

        return $data;
    }
    // debit balance
    public function AgentDebitBalance($receive)
    {
         $query  = DB::table('acc_transaction_infos')->select('debit_amount')
                        ->where('debit_acc', $receive['agent_id']);
         if(!empty($receive['from_date'])) {
             $query->where("trans_date", "<", $receive['from_date']);
         }
         return $query->sum('debit_amount');
    }
    // credit balance
    public function AgentCreditBalance($receive)
    {
             $query  = DB::table('acc_transaction_infos')->select('credit_amount')->where('credit_acc', $receive['agent_id']);
             if(!empty($receive['from_date'])) {
                 $query->where("trans_date", "<", $receive['from_date']);
             }
             return $query->sum('credit_amount');
    }
    public function searchAgentStatementSum($receive)
    {
        $query = DB::table("acc_transaction_infos AS TRNS")
            ->leftJoin('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'TRNS.credit_acc');

            })
            ->leftJoin('agent_records AS AGRD2', function($join){
                $join->on('AGRD2.id', '=', 'TRNS.debit_acc');

            })
            ->leftJoin('sales', function($join){
                $join->on('sales.id', '=', 'TRNS.sales_id');
            })

            ->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.trans_type','TRNS.debit_amount','TRNS.trans_date', 'TRNS.remarks','AGRD.name as agent_name','AGRD2.name as agent_name2','TRNS.reference_number','TRNS.remarks','TRNS.receipt_cheque_no','sales.invoice_no')
            ->orderBy('trans_date', 'ASC')->orderBy('id', 'ASC');

        if(!empty($receive['agent_id'])){
            $query->Where(function ($query) use ($receive) {
                $query->orWhere('TRNS.credit_acc', '=' , $receive['agent_id']);
                $query->orWhere('TRNS.debit_acc', '=' , $receive['agent_id']);
            });
        }
        if(!empty($receive['from_date']) && !empty($receive['to_date'])){
            $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['to_date']]);

        }
        // elseif($receive['from_date'] !='' && $receive['to_date'] ==''){
        //     $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['from_date']]);
        // }

        $data['data'] = $query->get();

        return $data;
    }

    public function balanceSum($receive,$field)
    {
        $query  = DB::table('acc_transaction_infos')->select($field);
        if(!empty($receive['from_date'])) {
            $query->where("trans_date", "=", $receive['from_date']);
        }
        return $query->sum($field);
    }

    public function searchAgentStatementPdf($receive)
    {
        $query = DB::table("acc_transaction_infos AS TRNS")
            ->leftJoin('sales', function($join){
                $join->on('sales.id', '=', 'TRNS.sales_id');
            })

            ->select(DB::raw('SQL_CALC_FOUND_ROWS TRNS.id'),'TRNS.credit_amount','TRNS.trans_type','TRNS.debit_amount','TRNS.trans_date', 'TRNS.remarks','TRNS.reference_number','TRNS.remarks','TRNS.receipt_cheque_no','sales.invoice_no')
            ->orderBy('trans_date', 'ASC')->orderBy('id', 'ASC');

        if(!empty($receive['from_date']) && !empty($receive['to_date'])){
            $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['to_date']]);

        }
        // elseif($receive['from_date'] !='' && $receive['to_date'] ==''){
        //     $query->whereBetween("TRNS.trans_date", [$receive['from_date'], $receive['from_date']]);
        // }

        $data = $query->get();

        return $data;
    }
}
