@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--responsive-mobile" id="kt_page_portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">Details</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="#" class="btn btn-success kt-margin-r-5">
                <span class="kt-hidden-mobile">Approve</span>
            </a>
            <a href="#" class="btn btn-danger kt-margin-r-5">
                <span class="kt-hidden-mobile">Cancel</span>
            </a>
            <a href="#" class="btn btn-brand">
                <span class="kt-hidden-mobile">Print</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-6">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Price Confirmation No.</span>
                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ fpc_details.fpc_id }}</span>
                </div>
                
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Status</span>
                    <span class="col-md-8">
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ fpc_details.status_name }}</span>
                    </span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Vehicle Type</span>
                    <span class="col-md-8">@{{ fpc_details.vehicle_type }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Date Created</span>
                    <span class="col-md-8">@{{ fpc_details.date_created }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Created by</span>
                    <span class="col-md-8">@{{ fpc_details.created_by }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Customer ID</span>
                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ customer_details.customer_id }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Customer Name</span>
                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ customer_details.customer_name }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Organization Type</span>
                    <span class="col-md-8">@{{ customer_details.org_type_name }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">TIN</span>
                    <span class="col-md-8">@{{ customer_details.tin }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Address</span>
                    <span class="col-md-8">@{{ customer_details.address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kt-portlet kt-portlet--height-fluid" v-for="(project, index) in projects">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @{{ project.dealer_account }}
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

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Price</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>Suggested Price</th>
                            <th>More details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in project.requirements">
                            <td>
                                <a href="#" @click.prevent="priceConfirmation(order,project.dealer_account)" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-money-bill-wave"></i>
                                </a>
                            </td>
                            <td> @{{ order.sales_model }} </td>
                            <td> @{{ order.color }} </td>
                            <td> @{{ order.quantity }} </td>
                            <td> @{{ order.suggested_price }} </td>
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
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="priceConfirmationModal" style="z-index:1131" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" @click="updateActiveTab(0)" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="true">Order Detail</a>
                        <a class="nav-item nav-link"  @click="updateActiveTab(1)" data-toggle="tab" href="#nav-addtl" role="tab" aria-controls="nav-addtl" aria-selected="false">Additional Detail</a> 
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-orders" role="tabpanel" aria-labelledby="nav-home-tab">

                        
                      
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="details-item">
                                            <span class="details-label">Account Name</span>
                                            <span class="details-subtext">@{{ customer_details.customer_name}}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Dealer</span>
                                            <span class="details-subtext">@{{ curDealerAccount }}</span>
                                        </div>

                                         <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">@{{ curModel.sales_model }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">@{{ curModel.quantity }}</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Project No.</span>
                                            <span class="details-subtext">@{{ curModel.project_id }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Suggested Price</span>
                                            <span class="details-subtext">@{{ curModel.suggested_price }}</span>
                                        </div> 
                                    </div>
                                </div>          
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="form-horizontal">
                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">One Price</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control form-control-sm" v-model="curModel.one_price" />
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Wholesale Price</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control form-control-sm" v-model="curModel.wholesale_price" />
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Dealer's Margin</label>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control" v-model="curModel.dealers_margin" aria-describedby="basic-addon2">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" disabled="" class="form-control form-control-sm" :value="formatPrice(calculateMargin)" />
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">LTO Registration</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control form-control-sm" v-model="curModel.lto_registration" />
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Freebies</label>
                                                <div class="col-lg-9">
                                                    <input type="text" :value="formatPrice(sumFreebies)" class="form-control form-control-sm" disabled="" />
                                                </div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Cost</label>
                                                <div class="col-lg-9">
                                                    <input type="text" :value="formatPrice(calculateCost)" class="form-control form-control-sm" disabled="" />
                                                </div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Net Cost</label>
                                                <div class="col-lg-9">
                                                    <input type="text" :value="formatPrice(calculateNetCost)" class="form-control form-control-sm" disabled="" />
                                                </div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Fleet Price</label>
                                                <div class="col-lg-9">
                                                    <input type="text" v-model="curModel.fleet_price" class="form-control form-control-sm" />
                                                </div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Subsidy</label>
                                                <div class="col-lg-9">
                                                    <input type="text" :value="formatPrice(calculateSubsidy)" class="form-control form-control-sm" disabled="" />
                                                </div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:.5em !important;">
                                                <label class="col-lg-3 col-form-label">Total IPC Subsidy</label>
                                                <div class="col-lg-9">
                                                    <input type="text" :value="formatPrice(calculateTotalSubsidy)" class="form-control form-control-sm" disabled="" />
                                                </div>
                                            </div>

                                        </form>
                                       
                                    </div>
                                </div>
                                
                            </div>

                        </div>


                    </div>
                    <div class="tab-pane fade" id="nav-addtl" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:60%;">Description</th>
                                    <th style="width:30%;">Amount</th>
                                    <th style="width:10%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail, index) in additional_details">
                                    <td><input type="text" class="form-control" v-model="detail.description" /></td>
                                    <td><input type="text" class="form-control" v-model="detail.amount" /></td>
                                    <td><a href="#" @click.prevent="deleteRow(index)" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn"></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Save changes</button>
                <a href="#" @click.prevent="printPrintConfirmation(project_id)" class="btn btn-primary">Print</a>
                <button type="button" v-if="active_tab == 1" class="btn btn-primary" @click="addRow()">Add row</button>
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

    var vm =  new Vue({
        el : "#app",
        data: {
            fpc_details : {!! json_encode($fpc_details) !!},
            customer_details : {!! json_encode($customer_details) !!},
            projects : {!! json_encode($projects) !!},
            curModel : [],
            curDealerAccount : '',
          /*  projects : [
                {
                    project_id : '001',
                    dealer : 'PASIG',
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
            ],*/
            additional_details : [],
            active_tab : 0
        },
        methods : {
            priceConfirmation(order,dealerAccount){
                this.curModel = order;
                this.curDealerAccount = dealerAccount;
                $("#priceConfirmationModal").modal('show');
            },
            addRow(){
                this.additional_details.push(
                    {
                        description : "",
                        amount : ""     
                    }
                );
            },
            deleteRow(index){
                this.additional_details.splice(index,1);
            },
            updateActiveTab(tab_id){
                this.active_tab = tab_id;
            },
            printPrintConfirmation(id){
                window.open(window.axios.defaults.baseURL + '/api/print-price-confirmation/' + id);
            },
            submitFPC(){
                Swal.fire({
                    type: 'success',
                    title: 'Price confirmation has been submitted!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-price-confirmation') }}";
                    }
                });
            },
            showAdditionalDetails(){
                $("#additionalDetailsModal").modal('show');
            },
            formatPrice(value) {
                return (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            }
        },
        created: function () {
            // `this` points to the vm instance
            
        },
        mounted : function () {

        },
        computed: {
            sumFreebies(){
                return this.additional_details.reduce((acc,item) => parseFloat(acc) + parseFloat(item.amount),0);
            },
            calculateCost(){
                return (parseFloat(this.curModel.one_price) + parseFloat(this.calculateMargin) + parseFloat(this.sumFreebies));
            },
            calculateMargin(){
                return (parseFloat(this.curModel.fleet_price) - parseFloat(this.sumFreebies)) * parseFloat(this.curModel.dealers_margin/100);
            },
            calculateNetCost(){
                return (parseFloat(this.curModel.wholesale_price) + parseFloat(this.calculateMargin) + parseFloat(this.curModel.lto_registration));
            },
            calculateSubsidy(){
                return (parseFloat(this.calculateNetCost) - parseFloat(this.curModel.fleet_price));
            },
            calculateTotalSubsidy(){
                return (parseFloat(this.calculateSubsidy) * parseFloat(this.curModel.quantity));
            }
        }

        
    });
</script>
@endpush