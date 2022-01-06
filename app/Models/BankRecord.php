<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class BankRecord extends Model
{
    use HasFactory;

    public function get_bank_debit_list_data($receive, $search_content)
    {
    	$query = DB::table("bank_records AS BRCD")
    	    ->join('banks AS BNK', function($join){
                $join->on('BNK.id', '=', 'BRCD.bank_id');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS BRCD.id'),'BRCD.amount','BRCD.transaction_date', 'BRCD.remarks',  'BNK.name as bank_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('BRCD.type', '=', 1)
            ->orderBy('BRCD.id', 'DESC');

        if($search_content != false){
            $query->Where("BNK.name", "LIKE", $search_content)
                    ->orWhere("BRCD.remarks", "LIKE", $search_content);
        }

        if($receive['bank_id'] !=''){
                $query->Where("BRCD.bank_id", "=", $receive['bank_id']);
            }
        if($receive['trans_date'] !=''){
            $query->Where("BRCD.transaction_date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-m-Y', strtotime($row->transaction_date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function get_bank_credit_list_data($receive, $search_content)
    {
    	$query = DB::table("bank_records AS BRCD")
    	    ->join('banks AS BNK', function($join){
                $join->on('BNK.id', '=', 'BRCD.bank_id');

             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS BRCD.id'),'BRCD.amount','BRCD.transaction_date', 'BRCD.remarks',  'BNK.name as bank_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('BRCD.type', '=', 2)
            ->orderBy('BRCD.id', 'DESC');

        if($search_content != false){
            $query->Where("BNK.name", "LIKE", $search_content)
                    ->orWhere("BRCD.remarks", "LIKE", $search_content);
        }

        if($receive['bank_id'] !=''){
                $query->Where("BRCD.bank_id", "=", $receive['bank_id']);
            }
        if($receive['trans_date'] !=''){
            $query->Where("BRCD.transaction_date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-m-Y', strtotime($row->transaction_date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }
}
