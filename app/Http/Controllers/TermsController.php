<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;

class TermsController extends Controller
{
    public function index(){
     
        $terms = \App\Models\Term::all();
      
        $page_data = array(
            'base_url'      => url('/'),
            'terms'         => $terms,
            'status_colors' => config('app.status_colors')
        );
    	return view('terms.list',$page_data);
    }

    public function store(Request $request){
        $term            = new Term;
        $term->term_name = $request->term_name;
        $term->status    = 1;
        $term->save();

        $terms = \App\Models\Term::all();
        return response()->json($terms);
    }

    public function update(Request $request){
        $term            = new Term;
        $term            = \App\Models\Term::find($request->term_id);
        $term->term_name = $request->term_name;
        $term->status    = $request->status;
        $term->save();

        $terms = \App\Models\Term::all();
        return response()->json($terms);    

    }
}
