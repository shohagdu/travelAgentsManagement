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

    public function bank_deposit(){
        //DB::enableQueryLog();
                    
         return $query  = DB::table("banks AS BNK")
                        ->select('BNK.name as name_name','BNK.account_no','BNK.branch_name','cr.creditAmount as credit_amount','dr.debitAmount as debit_amount')
                        ->leftJoinSub(self::CreditAmountSubQuery(), 'cr', function($pcs) {
                        $pcs->on('cr.bank_id', '=', 'BNK.id');
                        })
                        ->leftJoinSub(self::getDebitAmount(), 'dr', function($pcs) {
                        $pcs->on('dr.bank_id', '=', 'BNK.id');
                        })
                        ->where('BNK.type', '=', 2)
                        ->where('BNK.is_active', '=',1)
                        ->orderBy('BNK.id', 'DESC')
                        ->groupBy('BNK.id')
                        ->get();

    //    echo "<pre>";
    //    print_r(DB::getQueryLog($query));exit;          
    }
    public function get_credit_deposit(){
         return DB::table("bank_records")
                    ->selectRaw('SUM(amount) AS creditAmount')
                    ->where('type','=',2)
                    ->where('is_active','=',1)
                    ->first();    
    }
    public function get_debit_deposit(){
        return DB::table("bank_records")
                   ->selectRaw('SUM(amount) AS debitAmount')
                   ->where('type','=',1)
                   ->where('is_active','=',1)
                   ->first();    
    }    
    public static  function CreditAmountSubQuery()
    {
        return DB::table("bank_records")
            ->selectRaw('SUM(amount) AS creditAmount')
            ->where('type','=',2)
            ->where('is_active','=',1)
            ->groupBy('bank_id');
    }
    public static  function getDebitAmount()
    {
        return DB::table("bank_records as drTbl")
            ->selectRaw('SUM(drTbl.amount) AS debitAmount,drTbl.bank_id')
            ->where('drTbl.type','=',1)
            ->where('drTbl.is_active','=',1)
            ->groupBy('drTbl.bank_id');
    }

    public function searchBankStatement($receive)
    {
        $query = DB::table("bank_records AS BARD")
            ->leftJoin('banks AS BNK', function($join){
                $join->on('BNK.id', '=', 'BARD.bank_id');
            })
            ->where('BARD.is_active',1)
            ->select('BARD.amount','BARD.type','BARD.transaction_date', 'BARD.remarks','BNK.name as bank_name')
            ->orderBy('BARD.transaction_date', 'ASC')
            ->orderBy('BARD.id', 'ASC');

        if(!empty($receive['bank_id'])){
            $query->Where(function ($query) use ($receive) {
                $query->orWhere('BARD.bank_id', '=' , $receive['bank_id']);
                $query->orWhere('BARD.bank_id', '=' , $receive['bank_id']);
            });
        }
        if(!empty($receive['from_date']) && !empty($receive['to_date'])){
            $query->whereBetween("BARD.transaction_date", [$receive['from_date'], $receive['to_date']]);

        }
    
        $data['data'] = $query->get();

        return $data;
    }

    // bank debit amount
    public function BankDebitBalance($receive)
    {
         $query  = DB::table('bank_records')->select('amount')
                                            ->where('bank_id', $receive['bank_id'])
                                            ->where("type", "=", 1);

                                            if(!empty($receive['from_date'])) {
                                                $query->where("transaction_date", "<", $receive['from_date']);
                                            }
         return $query->sum('amount');
    }
    // bank credit amount
    public function BankCreditBalance($receive)
    {
             $query  = DB::table('bank_records')->select('amount')
                                                ->where('bank_id', $receive['bank_id'])
                                                ->where("type", "=", 2);

                                                if(!empty($receive['from_date'])) {
                                                    $query->where("transaction_date", "<", $receive['from_date']);
                                                }
             return $query->sum('amount');
    }
}
