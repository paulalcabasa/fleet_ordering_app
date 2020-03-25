<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ValueSetCategory;
use App\Models\ValueSetName;

class ValueSetController extends Controller
{
    public function index(){
        $categories = ValueSetCategory::all();
        $value_sets = ValueSetName::with('category')->get();
        $page_data = [
            'categories' => $categories,
            'value_sets' => $value_sets,
            'base_url'   => url('/')
        ];
        return view('value_sets', $page_data);
    }

    public function store(Request $request){
        $value_set = new ValueSetName;
        $value_set->category_id = $request->category_id;
        $value_set->description = $request->description;
        $value_set->save();
        $value_sets = ValueSetName::with('category')->get();
        return response()->json([
            'value_sets' => $value_sets
        ]);
    }

    public function updateValueSet(Request $request){
        $value_set                     = new ValueSetName;
        $value_set                     = \App\Models\ValueSetName::find($request->value_set_id);
       
        $value_set->category_id        = $request->category_id;
        $value_set->description        = $request->description;
        $value_set->update_user        = session('user')['user_id'];
        $value_set->update_user_source = session('user')['source_id'];
        $value_set->save();
        $value_sets = ValueSetName::with('category')->get();
        return response()->json([
            'message'    => 'Saved',
            'value_sets' => $value_sets
        ]);   
    }

    public function destroy(Request $request){
        $value_set                     = new ValueSetName;
        $value_set                     = \App\Models\ValueSetName::find($request->value_set_id);
        $value_set->delete(); 
    }

    
}
