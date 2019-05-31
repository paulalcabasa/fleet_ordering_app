@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg" style="">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">Entry</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="#" @click="createPriceConfirmation()" class="btn btn-brand">
                <span class="kt-hidden-mobile">Create</span>
            </a>
         
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-md-4">
                <label>Account No</label>
                <input type="text" name="" class="form-control" value="CUST001" readonly="" />
            </div>
            <div class="col-md-8">
               <label>Account Name</label>
                <select class="form-control" id="sel_customer" v-model="selected_customer" v-select></select>
            </div>
        </div>
    </div>
</div>

<div class="kt-portlet kt-portlet--height-fluid" v-for="(project, index) in projects">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @{{ project.dealer }}
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" :href="'#orders_tab_' + index" role="tab" aria-selected="true">
                        Requirement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="'#competitors_tab_' + index" role="tab" aria-selected="false">
                        Competitor
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" :id="'orders_tab_' + index">
              <!--   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name of Body Builder </label>
                            <span class="form-control">@{{ project.body_builder_name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rear Body Type</label>
                            <span class="form-control">@{{ project.rear_body_type}}</span>
                        </div>
                    </div>
                </div> -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>Suggested Price</th>
                            <th>More Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in project.orders">
                            <td> @{{ order.model }} </td>
                            <td> @{{ order.color }} </td>
                            <td> @{{ order.ordered_quantity }} </td>
                            <td> @{{ order.srp }} </td>
                            <td>
                                <button type="button" @click="showAdditionalDetails()" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-info-circle"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" :id="'competitors_tab_'+ index">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(competitor, index) in project.competitors">
                            <td> @{{ competitor.brand }} </td>
                            <td> @{{ competitor.model }} </td>
                            <td> @{{ competitor.price }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

   <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-danger">Remove</button>
            </div>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">More Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#additional_details">Additional Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#delivery_schedule">Delivery Schedule</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="additional_details" role="tabpanel">
                        <div class="details-item">
                            <span class="details-label">Name of Body Builder</span>
                            <span class="details-subtext">Almazora</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Rear Body Type</span>
                            <span class="details-subtext">Wingvan</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Additional Items</span>
                            <span class="details-subtext">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                Sed vehicula ornare nibh a pulvinar. 
                                Maecenas hendrerit tincidunt porta.
                            </span>
                        </div>  
                    </div>
                    <div class="tab-pane" id="delivery_schedule" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">D-MAX RZ4E 4x2 Cab/Chassis</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Color</span>
                                            <span class="details-subtext">Red Spinel Mica</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Quantity</td>
                                            <td>Date</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5</td>
                                            <td>June 5, 2019</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>June 10, 2019</td>
                                        </tr>
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->



</div>

@stop

@push('scripts')
<script>
var Select2 = function(customerOptions){

    var initSelCustomer = function(customerOptions){
        $('#sel_customer').select2({
            placeholder: "Select a customer",
            data: customerOptions
        });
    }

    return {
        init : function(customerOptions){
            initSelCustomer(customerOptions);
        }
    };
}();


</script>
<script>


    function updateFunction (el, binding) {
        // get options from binding value. 
        // v-select="THIS-IS-THE-BINDING-VALUE"
        let options = binding.value || {};

        // set up select2
        $(el).select2(options).on("select2:select", (e) => {
            // v-model looks for
            //  - an event named "change"
            //  - a value with property path "$event.target.value"
            el.dispatchEvent(new Event('change', { target: e.target }));
        });
    }

    Vue.directive('select', {
        inserted: updateFunction ,
        componentUpdated: updateFunction,
    });


    var vm =  new Vue({
        el : "#app",
        data: {
            customerOptions : [
                {
                    id : 0,
                    text : "RCP SENIA TRADING/ RCP SENIA TRANSPORT"
                },
                {
                    id : 1,
                    text : "MUNICIPAL GOVERNMENT OF CALAUAG"
                },
                {
                    id : 2,
                    text : "HOME OFFICE SPECIALIST"
                }
            ],
            selected_customer : 0,
            projects : [
                {
                    project_id : '001',
                    dealer : 'PASIG',
                    body_builder_name : 'Almazora',
                    rear_body_type : 'Jeepney',
                    orders : [
                        {
                            model : 'QKR77 (CAB-LESS 80A)',
                            color : 'WHITE',
                            ordered_quantity : 50,
                            particulars : '',
                            srp : '1200000'
                        },
                        {
                            model : '185 D-MAX 3.0 4x4 LS MT',
                            color : 'SPLASH WHITE',
                            ordered_quantity : 20,
                            particulars : '',
                            srp : '1200000'
                        }
                    ],
                    competitors: [
                        {
                            brand : 'MITSUBUSHI',
                            model : 'FUSO',
                            price : '1,100,000.00'
                        }
                    ]
                },
                {
                    project_id : '001',
                    dealer : 'MAKATI',
                    body_builder_name : 'Almazora',
                    rear_body_type : 'Jeepney',
                    orders : [
                        {
                            model : 'QKR77 (CAB-LESS 80A)',
                            color : 'WHITE',
                            ordered_quantity : 50,
                            particulars : '',
                            srp : '1200000'
                        }
                    ],
                    competitors: [
                        {
                            brand : 'MITSUBUSHI 2',
                            model : 'FUSO 2',
                            price : '1,120,000.00'
                        }
                    ]
                }
            ]
        },
        methods : {
            createPriceConfirmation(){
                Swal.fire({
                    type: 'success',
                    title: 'You data has been saved!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "price-confirmation-details/submit/1";
                    }
                });
            },
            showAdditionalDetails(){
                $("#additionalDetailsModal").modal('show');
            },
        },
        created: function () {
            // `this` points to the vm instance
            
        },
        mounted : function () {
            Select2.init(this.customerOptions);
        }
    });
</script>
@endpush