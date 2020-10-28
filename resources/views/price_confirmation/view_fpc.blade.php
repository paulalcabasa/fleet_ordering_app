@extends('_layouts.metronic')

@section('page-title', 'FPC Approval')

@section('content')

<div id="app">
<div class="col-md-6">
    <div class="kt-portlet kt-portlet--mobile" >
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Details
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
            
                <a :href="approve_link" class="btn btn-success btn-sm kt-margin-r-5" >
                    <span class="kt-hidden-mobile">Approve</span>
                </a>
                <a :href="reject_link" class="btn btn-danger btn-sm kt-margin-r-5" >
                    <span class="kt-hidden-mobile">Reject</span>
                </a>
                <a :href="inquiry_link" target="_blank" class="btn btn-primary btn-sm" >
                    <span class="kt-hidden-mobile">Inquiry</span>
                </a>
            
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row kt-margin-b-5">
                        <span class="col-md-4 kt-font-bold">FPC No.</span>
                        <span class="col-md-8 kt-font-boldest kt-font-primary"><?php echo $fpcDetails->fpc_id; ?></span>
                    </div>
                    <div class="row kt-margin-b-5">
                        <span class="col-md-4 kt-font-bold">Fleet Account Name</span>
                        <span class="col-md-8 kt-font-bold kt-font-primary"><?php echo $fpcDetails->customer_name; ?></span>
                    </div> 
                    <div class="row kt-margin-b-5">
                        <span class="col-md-4 kt-font-bold">Vehicle Type</span>
                        <span class="col-md-8 kt-font-bold kt-font-primary"><?php echo $fpcDetails->vehicle_type; ?></span>
                    </div>
                    <div class="row kt-margin-b-5">
                        <span class="col-md-4 kt-font-bold">Prepared by</span>
                        <span class="col-md-8"><?php echo $fpcDetails->created_by; ?></span>
                    </div>
                    <div class="row kt-margin-b-5">
                        <span class="col-md-4 kt-font-bold">Date created</span>
                        <span class="col-md-8"><?php echo $fpcDetails->date_created; ?></span>
                    </div>
            
                </div>
            
            </div>
            
        </div>
    </div>
</div>
<div class="col-md-6"></div>

<div class="kt-portlet kt-portlet--height-fluid" v-for="project in projects">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Project No. @{{ project.project_id }} - @{{ project.dealer_name }} (@{{ project.dealer_account }} ) 
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
         
            <a target="_blank" :href="base_url + '/print-fpc/' + project.fpc_project_id" class="btn btn-primary" >
                <span class="kt-hidden-mobile">Print</span>
            </a>
        </div> 
    </div>
    <div class="kt-portlet__body">
        <h5>Requirement</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-light-gray-2">
                        <th>Model</th>
                        <th>Qty</th>
                        <th>SRP</th>
                        <th>Fleet Discount</th>
                        <th>Fleet Price</th>
                        <th>Subsidy</th>
                        <th>Inclusion</th>
                        <th>Validity</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(vehicle, index) in project.requirements">
                        <td>@{{ vehicle.sales_model }}</td>
                        <td>@{{ vehicle.quantity }}</td>
                        <td>@{{ vehicle.suggested_retail_price | formatPeso }}</td>
                        <td>@{{ vehicle.discount | formatPeso    }}</td>
                        <td>@{{ computeFleetPrice(vehicle) | formatPeso }}</td>
                        <td>@{{ computeSubsidy(vehicle) | formatPeso }}</td>
                        <td>@{{ vehicle.freebies | formatPeso }}</td>
                        <td>@{{ project.validity_disp }}</td>
                        <td>@{{ fpcDetails.remarks }}</td>
                    </tr>
                </tbody>
                
               
            </table>
        </div>

        <h5>Competitors</h5>
        <div class="table-responsive" v-if="project.competitors.length > 0">
            <table class="table table-bordered">
                <thead> 
                    <tr class="bg-light-gray-2">
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Price</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(competitor, index) in project.competitors">
                        <td>@{{ competitor.brand }}</td>
                        <td>@{{ competitor.model }}</td>
                        <td>@{{ competitor.price | formatPeso }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p v-if="project.competitors.length == 0">**** NO COMPETITOR ****</p>
    </div>
</div>




</div>
@stop


@push('scripts')
<script>

    var vm =  new Vue({
        el : "#app",
        data: {
            projects : {!! json_encode($projects) !!},  
            approval : {!! json_encode($approval) !!},  
            fpcDetails : {!! json_encode($fpcDetails) !!},  
            approve_link : {!! json_encode($approve_link) !!},  
            reject_link : {!! json_encode($reject_link) !!},  
            inquiry_link : {!! json_encode($inquiry_link) !!},  
            base_url : {!! json_encode($base_url) !!}
        },
        created: function () {
        },
        methods : {
            computeFleetPrice(vehicle){
                return parseFloat(vehicle.suggested_retail_price) - (parseFloat(vehicle.discount) + parseFloat(vehicle.promo));
               
            },
            computeSubsidy(vehicle){
                let fleet_price =  parseFloat(vehicle.suggested_retail_price) - (parseFloat(vehicle.discount) + parseFloat(vehicle.promo));
                let dealer_margin    = parseFloat(fleet_price) * parseFloat((vehicle.dealers_margin/100));
                let net_cost          = parseFloat(vehicle.wholesale_price) + parseFloat(vehicle.lto_registration) + parseFloat(vehicle.freebies) + parseFloat(dealer_margin);
                let subsidy = parseFloat(net_cost) - parseFloat(fleet_price);
                let total_subsidy    = parseFloat(subsidy) * parseFloat(vehicle.quantity);
                return total_subsidy;
                 // $srp              = $vehicle->suggested_retail_price;
                // $wsp              = $vehicle->wholesale_price;
                // $fleet_price 	  =	$srp - ($vehicle->discount + $vehicle->promo);
                // $dealer_margin    = $fleet_price * ($vehicle->dealers_margin/100);
                // $margin_percent   = $vehicle->dealers_margin;
                // $lto_registration = $vehicle->lto_registration;
                // $freebies         = $vehicle->freebies;

                // $promo            = $vehicle->promo;
                // $net_cost         = $wsp +  $lto_registration + $freebies + $dealer_margin;
                // $subsidy          = $net_cost - $fleet_price;
                // $total_subsidy    = $subsidy * $vehicle->quantity;
            }
        },
        computed : {
           
        },
        mounted : function () {
            
        },
        filters: {
            formatPeso: function (value) {
                 return `${parseFloat(value).toLocaleString()}`
            }
        }
    });


   
</script>
@endpush