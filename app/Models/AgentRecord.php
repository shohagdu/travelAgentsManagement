<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class AgentRecord extends Model
{
    use HasFactory;

    public function agent_list_data($receive, $search_content)
    {

    	$query = DB::table("agent_records AS AGNT")

    	    ->join('countries AS CNT', function($join){
                $join->on('CNT.id', '=', 'AGNT.country');
           
             })
            ->join('states AS STE', function($join){
                $join->on('STE.id', '=', 'AGNT.city');
           
             })		
            
    		->select(DB::raw('SQL_CALC_FOUND_ROWS AGNT.id'), 'AGNT.name','AGNT.mobile','AGNT.email', 'CNT.name as country_name','STE.name as city_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->orderBy('id', 'DESC');

        if($search_content != false){

            $query->Where("AGNT.name", "LIKE", $search_content)
                    ->orWhere("AGNT.mobile", "LIKE", $search_content);
         
        }

		if($receive['country'] !=''){
                $query->Where("AGNT.country", "=", $receive['country']);
            }
        if($receive['city'] !=''){
                $query->Where("AGNT.city", "=", $receive['city']);
            }    
        if($receive['mobile'] !=''){
                $query->Where("AGNT.mobile", "=", $receive['mobile']);
            }

        $data['data'] = $query->get();

        return $data;
    }

    public function transaction_info_data($id){
        
        $trans_query = DB::table("acc_transaction_infos AS TRNS")
                     ->select('TRNS.*', 'TRNS.debit_amount','TRNS.credit_amount','ACC.name as account_name')
                     ->leftJoin('banks AS ACC', function($join){
                        $join->on('ACC.id', '=', 'TRNS.debit_acc');
                     })
                     ->where(function ($trans_query) use ($id) {
                        $trans_query->where('TRNS.debit_acc', '=' , $id)
                            ->orWhere('TRNS.credit_acc', '=', $id);
                    })
                    ->where('TRNS.trans_type', '!=',3);

        return $data = $trans_query->get();
                        
    }
}
