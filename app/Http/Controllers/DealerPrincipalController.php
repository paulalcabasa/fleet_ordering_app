<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\DealerPrincipal;


class DealerPrincipalController extends Controller
{
    public function index(){
        $dealers = Dealer::all();
        $data = DealerPrincipal::with('dealer')->where('status',1)->get();
        $page_data = [
            'dealers'       => $dealers,
            'list'          => $data,
            'status_colors' => config('app.status_colors'),
            'user_type'     => session('user')['user_type_id'],
            'base_url'      => url('/')
        ];
        return view('dealer_principal.list', $page_data);
    }

    public function store(Request $request){
        $principal                     = new DealerPrincipal;
        $principal->name               = $request->name;
        $principal->mobile_no          = $request->mobile_no;
        $principal->email_address      = $request->email_address;
        $principal->position           = $request->position;
        $principal->dealer_id          = $request->dealer_id;
        $principal->created_by         = session('user')['user_id'];
        $principal->create_user_source = session('user')['source_id'];
        $principal->save();

        $data = DealerPrincipal::with('dealer')->where('status',1)->get();
        return response()->json([
            'message' => 'Saved',
            'principals' => $data
        ]);
    }

    public function update(Request $request){
        $principal                     = new DealerPrincipal;
        $principal                     = \App\Models\DealerPrincipal::find($request->principal_id);
        $principal->name               = $request->name;
        $principal->mobile_no          = $request->mobile_no;
        $principal->email_address      = $request->email_address;
        $principal->position           = $request->position;
        $principal->dealer_id          = $request->dealer_id;
        $principal->updated_by         = session('user')['user_id'];
        $principal->update_user_source = session('user')['source_id'];
        $principal->save();
        $data = DealerPrincipal::with('dealer')->where('status',1)->get();
        return response()->json([
            'message' => 'Saved',
            'principals' => $data
        ]);   

    }

    public function destroy(Request $request){
        $principal                     = new DealerPrincipal;
        $principal                     = \App\Models\DealerPrincipal::find($request->principal_id);
        $principal->delete(); 
    }
}
