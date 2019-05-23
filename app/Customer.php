<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
    public function get_scope_of_business($scope_of_business){
    /*	$sql = "SELECT class_code,
    				   class_code_description
        		FROM hz_class_code_denorm
            	WHERE 1 = 1
            		AND enabled_flag = :enabled_flag
            		AND class_code_description like :scope_of_business
            		AND rownum <= 10";
    	$query = DB::connection('oracle')->select($sql,['enabled_flag' => 'Y', 'scope_of_business' => $scope_of_business]);*/
    	$query = DB::connection('oracle')
    			->table('hz_class_code_denorm')
    			->selectRaw(DB::raw('distinct class_code_description, class_code'))
    			->whereRaw("lower(class_code_description) like '%".strtolower($scope_of_business)."%' and enabled_flag = 'Y'")
    			->limit(5)
                ->get();
    	return $query;
    }
}
