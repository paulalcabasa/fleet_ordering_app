<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function get_vehicle_models(Request $request, Vehicle $vehicle){
    	$vehicle_type = $request->vehicle_type;
    	$data = $vehicle->get_vehicle_models($vehicle_type);
    	//return response()->json(['data' => $data]);
		$grouped = collect($data)->groupBy('model_variant'); // $data->groupBy('model_variant');
		$vehicle_options = array();
		foreach($grouped as $model => $variant){

			$children = array();
			foreach($variant as $var){
				$temp_array = array(
					"id" => $var->sales_model,
					"value" => $var->sales_model
				);
				array_push($children,$temp_array);
			}
			$option = array(
				"model" => $model,
				"variants" => $children
			);
			array_push($vehicle_options, $option);
		}

    	/*
    	return response()->json(
    		[
    			"results" => $vehicle_options,
    			"pagination" => ["more" => true]
    		]
    	);
    	*/
    	return response()->json(
    		[
    			"data" => $vehicle_options
    		]
    	);
    }

    public function get_vehicle_colors(Request $request, Vehicle $vehicle){
		$sales_model = $request->sales_model;
		$data = $vehicle->get_model_colors($sales_model);
		return $data;
	}
	
	public function getVehicleColorWithPrice(Request $request, Vehicle $vehicle){
		$sales_model = $request->sales_model;
		$data = $vehicle->get_model_colors_with_price($sales_model);
		return $data;
	}
	
	
}
