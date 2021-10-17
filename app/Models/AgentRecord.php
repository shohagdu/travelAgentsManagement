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
            
    		->select(DB::raw('SQL_CALC_FOUND_ROWS AGNT.id'), 'AGNT.name','AGNT.mobile','AGNT.mobile', 'CNT.name as country_name','STE.name as city_name')

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
        if($receive['district_id'] !=''){
                $query->Where("AGNT.city", "=", $receive['city']);
            }    
        if($receive['mobile'] !=''){
                $query->Where("AGNT.mobile", "=", $receive['mobile']);
            }

        $data['data'] = $query->get();

        return $data;
    }
}
