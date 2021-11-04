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

        $data['data'] = $query->get();

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
            ->where('TRNS.trans_type', '=', 3)
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
}
