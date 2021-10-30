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
            ->where('TRNS.trans_type', 2)
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
}
