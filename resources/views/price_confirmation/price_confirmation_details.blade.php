@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg" style="">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">Details</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            @if($action == "validate"):
            <a href="#"class="btn btn-success kt-margin-r-5">
                <span class="kt-hidden-mobile">Approve</span>
            </a>
            <a href="#"class="btn btn-danger">
                <span class="kt-hidden-mobile">Reject</span>
            </a>
            @elseif($action == "submit")
            <a href="#"class="btn btn-brand" @click="submitFPC()">
                <span class="kt-hidden-mobile">Submit</span>
            </a>
          
            @endif
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
                <input type="text" class="form-control"  readonly="" value="RCP SENIA TRADING/ RCP SENIA TRANSPORT" aria-describedby="fname-error">
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
                <!-- <div class="row">
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
                            <th>Price</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>Suggested Price</th>
                            <th>More details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in project.orders">
                            <td>
                                <a href="#" @click.prevent="priceConfirmation(project.order)" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-money-bill-wave"></i>
                                </a>
                            </td>
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
                                            <span class="details-label">Order Control No.</span>
                                            <span class="details-subtext">001</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Account Name</span>
                                            <span class="details-subtext">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Dealer</span>
                                            <span class="details-subtext">PASIG</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Date</span>
                                            <span class="details-subtext">April 1, 2019</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">QKR77 (CAB-LESS 80A)</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">2</span>
                                        </div>
                                    </div>
                                </div>
                             <!--    <div class="form-group">
                                    <label>Order Control No.</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="001" />
                                </div>
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="RCP SENIA TRADING/ RCP SENIA TRANSPORT" />
                                </div>
                                <div class="form-group">
                                    <label>Dealer</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="PASIG" />
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="April 1, 2019" />
                                </div>
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="QKR77 (CAB-LESS 80A)" />
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="2" />
                                </div> -->
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Descrition</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>One Price</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Wholesale Price</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Dealer's Margin</td>
                                            <td>
                                                 <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control"  aria-describedby="basic-addon2">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon2">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control form-control-sm" value="10000" />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3 Yrs LTO Registration</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Freebies</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Cost</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Promo Title</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Promo</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Net Cost</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Fleet Price</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Subsidy</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                        <tr>
                                            <td>Total IPC Subsidy</td>
                                            <td><input type="text" class="form-control form-control-sm" /></td>
                                        </tr>
                                    </tbody>
                                </table>
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
            ],
            additional_details : [],
            active_tab : 0
        },
        methods : {
            priceConfirmation(order){
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
        },
        created: function () {
            // `this` points to the vm instance
            
        },
        mounted : function () {
          
        }
    });
</script>
@endpush