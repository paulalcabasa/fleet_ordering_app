<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InactiveVehicles;

class InactiveVehicleController extends Controller
{
    public function index(){
		$vehicle = new InactiveVehicles;
		$list = $vehicle->get_all_vehicles();
		$vehicles = [];

		foreach($list as $row){
			
			$status = $row->status == 'active' ? true : false;
			array_push($vehicles,
				[
					'inventory_item_id' => $row->inventory_item_id,
					'model_variant'     => $row->model_variant,
					'color'             => $row->color,
					'prod_model'        => $row->prod_model,
					'vehicle_type'      => $row->vehicle_type,
					'sales_model'       => $row->sales_model,
					'status'            => $status,
					'status_name'       => $row->status,
					'id'				=> $row->id
				]
			);
		}
        $page_data = array(
			'base_url'      => url('/'),
			'list'			=> $vehicles,
            'status_colors' => config('app.status_colors')
        );
    	return view('vehicle.list',$page_data);
	}

	public function destroy(Request $request){
		$vehicle = new InactiveVehicles;
		$model = $vehicle::find($request->id);
		$model->delete();
	}

	public function store(Request $request){
		$vehicle = new InactiveVehicles;
		$vehicle->inventory_item_id = $request->inventory_item_id;
		$vehicle->save();
	}
}
