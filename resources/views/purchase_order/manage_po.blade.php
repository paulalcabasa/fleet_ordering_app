@extends('_layouts.metronic')

@section('page-title', 'Purchase Order')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--mobile" >
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Entry
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Price Confirmation Reference</span>
                    <span class="details-subtext">FPC{{ $price_confirmation_id }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Account Name</span>
                    <span class="details-subtext">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date Confirmed</span>
                    <span class="details-subtext">May 20, 2019</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Confirmed By</span>
                    <span class="details-subtext">John Doe</span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Project Reference No.</span>
                    <span class="details-subtext">PRJ001</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date Submitted</span>
                    <span class="details-subtext">May 19, 2019</span>
                </div>
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
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>PO Number</label>
                        <input type="text" name="" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                        <label>PO Document</label>
                        <div></div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file for purchase order</label>
                        </div>
                    </div>
                </div>
                    
            
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <!-- th>Price</th> -->
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>PO Qty</th>
                            <th>Suggested Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in project.orders">
<!--                             <td>
                                <a href="#" @click.prevent="priceConfirmation(project.order)" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-money-bill-wave"></i>
                                </a>
                            </td> -->
                            <td> @{{ order.model }} </td>
                            <td> @{{ order.color }} </td>
                            <td> @{{ order.ordered_quantity }} </td>
                            <td> <input type="text" name="" class="form-control" size="4"/> </td>
                            <td> @{{ order.srp }} </td>
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
        <div class="row">
            <div class="col-lg-12 kt-align-right">
                @if($action == 'create')
                <button type="submit" class="btn btn-brand" @click="submitPO()">Submit</button>
                @elseif($action == 'validate')
                <button type="submit" class="btn btn-success" @click="approvePO()">Approve</button>
                <button type="submit" class="btn btn-danger">Reject</button>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="priceConfirmationModal" style="z-index:1131" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80% !important;" role="document">
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
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                </tr>  
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>One Price</td>
                                                    <td>@{{ one_price | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Wholesale Price</td>
                                                    <td>@{{ wholesale_price | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Dealer's Margin</td>
                                                    <td>@{{ dealers_margin | formatPeso  }} (@{{  dealers_margin_percent }}%)</td>
                                                </tr>
                                                <tr>
                                                    <td>3 Yrs LTO Registration</td>
                                                    <td>@{{ lto_registration | formatPeso }}</td>
                                                </tr>
                                                 <tr>
                                                    <td>Freebies</td>
                                                    <td>@{{ freebies | formatPeso }}</td>
                                                </tr>
                                                 <tr>
                                                    <td>Cost</td>
                                                    <td>@{{ cost | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Promo (RCP SENIA TRADING/ RCP SENIA TRANSPORT)</td>
                                                    <td>@{{ promo | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Net Cost</td>
                                                    <td>@{{ net_cost | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Fleet Price</td>
                                                    <td>@{{ fleet_price | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Subsidy</td>
                                                    <td>@{{ subsidy | formatPeso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total IPC Subsidy</td>
                                                    <td>@{{ subsidy | formatPeso }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detail, index) in additional_details">
                                    <td>@{{ detail.description }}</td>
                                    <td>@{{ detail.amount | formatPeso }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" @click.prevent="printPrintConfirmation(project_id)" class="btn btn-primary">Print</a>
            </div>
        </div>
    </div>
</div>





</div>
@stop


@push('scripts')
<script>

    var vm =  new Vue({
        el : "#app",
        data: {
            additional_details : [
                {
                    description : "Grille",
                    amount : 5000
                },
                {
                    description : "Grille 2",
                    amount : 5000
                }
            ],
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
                }
            ],
            one_price : 1570000,
            wholesale_price : 1475000,
            dealers_margin_percent : 6,
            lto_registration : 10500,
            freebies : 0,
            promo : 0,
            fleet_price : 1540000
        },
        created: function () {
            // `this` points to the vm instance
        },
        methods : {
            priceConfirmation(order){
                $("#priceConfirmationModal").modal('show');
            },
            submitPO(){

                Swal.fire({
                    type: 'success',
                    title: 'The purchase order has been successfully submitted!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-po') }} ";
                    }
                });
            }
        },
        computed : {
            dealers_margin(){
                return this.one_price * (this.dealers_margin_percent/100) ;
            },
            cost(){
                return this.wholesale_price + this.dealers_margin + this.lto_registration;
            },
            net_cost(){
                return (this.wholesale_price + this.dealers_margin + this.lto_registration) - this.promo;
            },
            subsidy(){
                return this.net_cost - this.fleet_price;
            }

        },
        mounted : function () {
            
          
        },
        filters: {
            formatPeso: function (value) {
                 return `${value.toLocaleString()}`
            }
        }
    });


   
</script>
@endpush