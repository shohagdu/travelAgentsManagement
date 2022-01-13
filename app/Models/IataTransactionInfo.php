<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IataTransactionInfo extends Model
{
    use HasFactory;
    public function get_iata_sale_list_data($receive, $search_content)
    {
    	$query = DB::table("iata_transaction_infos")
    		->select(DB::raw('SQL_CALC_FOUND_ROWS id'), 'add_amount','amount','date', 'remarks')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('type', '=', 1)
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("amount", "LIKE", $search_content)
                  ->orWhere("remarks", "LIKE", $search_content);
        }

        // if($receive['sale_category_id'] !=''){
        //     $query->Where("sale_category_id", "=", $receive['sale_category_id']);
        // }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-M-Y', strtotime($row->date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function get_iata_debit_list_data($receive, $search_content)
    {
    	$query = DB::table("iata_transaction_infos")
    		->select(DB::raw('SQL_CALC_FOUND_ROWS id'),'amount','date', 'remarks')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('type', '=', 2)
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("amount", "LIKE", $search_content)
                  ->orWhere("remarks", "LIKE", $search_content);
        }

        if($receive['trans_date'] !=''){
            $query->Where("date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-m-Y', strtotime($row->date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }
    
    public function get_iata_credit_list_data($receive, $search_content)
    {
    	$query = DB::table("iata_transaction_infos")
    		->select(DB::raw('SQL_CALC_FOUND_ROWS id'),'amount','date', 'remarks')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->where('type', '=', 3)
            ->orderBy('id', 'DESC');

        if($search_content != false){
            $query->Where("amount", "LIKE", $search_content)
                  ->orWhere("remarks", "LIKE", $search_content);
        }

        if($receive['trans_date'] !=''){
            $query->Where("date", "=", date('Y-m-d', strtotime($receive['trans_date'])));
        }

        $info = $query->get();
        $allData = [];
        if (!empty($info)) {
            foreach ($info as $key => $row) {
                $allData[$key] = $row;
                $allData[$key]->TransactionDate = date('d-m-Y', strtotime($row->date));
            }
        }
        $data['data'] = $allData;
        return $data;
    }

    public function searchIataStatement($receive)
    {
        $query = DB::table("iata_transaction_infos")
            ->where('is_active',1)
            ->select('type','amount','add_amount','date', 'remarks')
            ->orderBy('date', 'ASC')
            ->orderBy('id', 'ASC');

        if(!empty($receive['from_date']) && !empty($receive['to_date'])){
            $query->whereBetween("date", [$receive['from_date'], $receive['to_date']]);
        }
    
        $data['data'] = $query->get();

        return $data;
    }
    
}
