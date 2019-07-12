<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competitor;

class CompetitorController extends Controller
{
    
    public function ajax_get_competitor_brands(Request $request, Competitor $m_competitor){
        $query = $request->all();
        $brands = $m_competitor->get_brands($query['query']);
        $brands = json_decode(json_encode($brands), true);
        $brands = array_column($brands,'brand');
        return json_encode($brands);
    }

    public function ajax_get_competitor_models(Request $request, Competitor $m_competitor){
        $query = $request->all();
        $models = $m_competitor->get_models($query['query'],$query['brand']);
        $models = json_decode(json_encode($models), true);
        $models = array_column($models,'model');
        return json_encode($models);
    }
}
