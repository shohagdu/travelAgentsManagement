<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Sale extends Model
{
    use HasFactory;

    public function sale_list_data($receive, $search_content)
    {

    	$query = DB::table("sales AS SALE")

    	    ->join('agent_records AS AGRD', function($join){
                $join->on('AGRD.id', '=', 'SALE.agent_id');
           
             })
    		->select(DB::raw('SQL_CALC_FOUND_ROWS SALE.id'),'SALE.sale_amount','SALE.discount', 'SALE.amount', 'SALE.sale_category_id', 'AGRD.name as agent_name')

            ->offset($receive['start'])
            ->limit($receive['limit'])
            ->orderBy('id', 'DESC');

        if($search_content != false){

            $query->Where("AGRD.name", "LIKE", $search_content)
                    ->orWhere("AGRD.name", "LIKE", $search_content);
         
        }

		if($receive['sale_category_id'] !=''){
                $query->Where("SALE.sale_category_id", "=", $receive['sale_category_id']);
            }
        if($receive['agent_id'] !=''){
                $query->Where("SALE.agent_id", "=", $receive['agent_id']);
            }    

        $data['data'] = $query->get();

        return $data;
    }
}
