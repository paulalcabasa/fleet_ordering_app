<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PriceListHeader;
use App\Models\PriceListLine;
use App\Models\Vehicle;
class PriceListController extends Controller
{

    private $pl_header;
    private $pl_line;
    private $vehicle;

    public function __construct(){
        $this->pl_header = new PriceListHeader();
        $this->pl_line = new PriceListLine();
        $this->vehicle = new Vehicle();
    }
    public function all_pricelist(){

        $headers = $this->pl_header->get_headers();
    
        $page_data = [
            'base_url'      => url('/'),
            'headers'       => $headers,
            'status_colors' => config('app.status_colors')
        ];

    	return view('pricelist.list', $page_data);
    }

    public function add_pricelist(Request $request){
        $name        = $request->pricelist_name;
        $description = $request->description;
        $action      = $request->action;

        if($action == "add"){
            $header = PriceListHeader::where(
                [
                    ['name', $name ]
                ]
                )->first();
            
            if(!empty($header)){
                return [
                    'status' => 500,
                    'msg' => $name . ' already exists, please enter a unique name.'
                ];
            }

            $pricelist_header_id = $this->pl_header->insert_header(
                [
                    'name' => $name,
                    'description' => $description,
                    'status'                => 1, 
                    'created_by'            => session('user')['user_id'],
                    'create_user_source_id' => session('user')['source_id'],
                    'creation_date'         => Carbon::now()
                ]
            );

            return [
                'pricelist_header_id' => $pricelist_header_id,
                'msg' => $name . ' has been successfully added!'
            ];
        }

        else if ($action == "edit"){
            $pricelist_header_id = $request->pricelist_header_id;
            $status = $request->status ? 1 : 2;
            $params = [
                'pricelist_header_id'   => $pricelist_header_id,
                'pricelist_name'        => $name,
                'description'           => $description,
                'status'                => $status,
                'updated_by'            => session('user')['user_id'],
                'update_user_source_id' => session('user')['source_id']
            ];
            
            $this->pl_header->update_header($params);
            
        }
    }

    public function pricelist_details(Request $request){
        
        $pricelist_header_id = $request->pricelist_header_id;
        $header = $this->pl_header->get_details($pricelist_header_id);

        $vehicle_models   = $this->vehicle->get_vehicles_with_price();
        $grouped          = collect($vehicle_models)->groupBy('model_variant'); 
        $vehicle_options  = array();
        
        foreach($grouped as $model => $variant){

            $children = array();
            foreach($variant as $var){
                $temp_array = array(
                    "id"           => $var->sales_model,
                    "value"        => $var->sales_model,
                    "vehicle_type" => $var->vehicle_type,
                    "variant"      => $var->model_variant
                );
                array_push($children,$temp_array);
            }
            $option = array(
                "model" => $model,
                "variants" => $children
            );
            array_push($vehicle_options, $option);
        }

  
        $page_data = [
            'base_url'            => url('/'),
            'header_data'         => $header,
            'vehicle_models'      => $vehicle_options,
            'vehicle_colors'      => config('app.vehicle_badge_colors'),
            'status_colors'       => config('app.status_colors')
        ];

    	return view('pricelist.details', $page_data);
    }

    public function add_pricelist_line(Request $request){
        $vehicle_details     = $request->vehicle;
        $pricelist_header_id = $request->pricelist_header_id;
        $action              = $request->action;
        $srp                 = str_replace(',','',$vehicle_details['srp']);
        $wsp                 = str_replace(',','',$vehicle_details['wsp']);
        $promo               = str_replace(',','',$vehicle_details['promo']);
        $lto_registration    = str_replace(',','',$vehicle_details['lto_registration']);

        if($action == "add"){

            $line = PriceListLine::where(
               [
                   ['inventory_item_id', $vehicle_details['inventory_item_id'] ],
                   ['status' , 1],
                   ['pricelist_header_id', $pricelist_header_id ]
               ]
            )->first();
            
            if(!empty($line)){
                return [
                    'status' => 500,
                    'msg' => 'There is an active pricelist for this model.'
                ];
            }

            $this->pl_line->insert_line([
                'pricelist_header_id'   => $pricelist_header_id,
                'inventory_item_id'     => $vehicle_details['inventory_item_id'],
                'vehicle_source_id'     => $vehicle_details['vehicle_source_id'],
                'srp'                   => $srp,
                'wsp'                   => $wsp,
                'promo'                 => $promo,
                'lto_registration'      => $lto_registration,
                'status'                => 1,
                'created_by'            => session('user')['user_id'],
                'create_user_source_id' => session('user')['source_id'],
                'creation_date'         => Carbon::now()
            ]);
            
            return [
                'status' => 200,
                'msg' => 'Sucessfully added to pricelist!'
            ];

            
        }
        else if($action == "edit"){
            $status = $vehicle_details['status_flag'] ? 1 : 2;

            // if a deactivated model has been reactivated, check first if there are existing active models
            if($vehicle_details['status'] == 2 && $status == 1){
                $line = PriceListLine::where(
                [
                    ['inventory_item_id', $vehicle_details['inventory_item_id'] ],
                    ['status' , 1]
                ]
                )->first();
                
                if(!empty($line)){
                    return [
                        'status' => 500,
                        'msg' => 'There is an active pricelist for this model.'
                    ];
                }
            }


            $params = [
                'pricelist_line_id'   => $vehicle_details['pricelist_line_id'],
                'srp'                   => $srp,
                'wsp'                   => $wsp,
                'promo'                 => $promo,
                'lto_registration'      => $lto_registration,
                'status'                => $status,
                'updated_by'            => session('user')['user_id'],
                'update_user_source_id' => session('user')['source_id'],
            ];
            $this->pl_line->update_line($params);

            return [
                'status' => 200,
                'msg' => 'Sucessfully updated pricelist!'
            ];
        }
    }

    public function get_pricelist_lines(Request $request){
        $pricelist_header_id = $request->pricelist_header_id;
        $lines = $this->pl_line->get_lines($pricelist_header_id);
        return $lines;
    }

    public function get_vehicle_price(Request $request){
        $pricelist_header_id = $request->pricelist_header_id;
        $inventory_item_id = $request->inventory_item_id;
        $vehicle_source_id = $request->vehicle_source_id;
        $vehicle_price = $this->pl_line->get_vehicle_price($pricelist_header_id, $inventory_item_id, $vehicle_source_id);
        if(empty($vehicle_price)){
            return response()->json(['status' => 404]);
        }
        
        return response()->json([
            'status' => 200,
            'price' => $vehicle_price
        ]);
            
    }
}
