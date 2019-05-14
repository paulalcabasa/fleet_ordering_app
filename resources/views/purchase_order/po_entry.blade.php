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
                <div class="form-group">
                    <label>Price Confirmation Reference</label>
                    <input type="text" class="form-control" value="FPC{{ $price_confirmation_id }}" disabled="disabled" />
                </div>
            </div>
            <div class="col-md-8">
               <div class="form-group">
                    <label>Account Name</label>
                    <input type="text" class="form-control" value="RCP SENIA TRADING/ RCP SENIA TRANSPORT" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Date Confirmed</label>
                    <input type="text" class="form-control" value="May 20, 2019" disabled="disabled" />
                </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                    <label>Confirmed By</label>
                    <input type="text" class="form-control" value="Paul Alcabasa" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Project Reference No.</label>
                    <input type="text" class="form-control" value="PRJ001" disabled="disabled" />
                </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                    <label>Date Submitted</label>
                    <input type="text" class="form-control" value="May 19, 2019" disabled="disabled"/>
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
                <div class="row">
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
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Price</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>Particulars</th>
                            <th>Suggested Price</th>
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
                            <td> @{{ order.particulars }} </td>
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
                                <div class="form-group">
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
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>One Price</label>
                                    <input type="text" class="form-control form-control-sm"  value="" />
                                </div>
                                <div class="form-group">
                                    <label>Wholesale Price</label>
                                    <input type="text" class="form-control form-control-sm" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Dealer's Margin</label>
                                    
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm" value="10000" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control"  aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>3 Yrs LTO Registration</label>
                                    <input type="text" class="form-control form-control-sm"  value="" />
                                </div>
                                <div class="form-group">
                                    <label>Freebies</label>
                                    <input type="text" class="form-control form-control-sm" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" value="" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Promo Title</label>
                                    <input type="text" class="form-control form-control-sm"  />
                                </div>
                                <div class="form-group">
                                    <label>Promo</label>
                                    <input type="text" class="form-control form-control-sm" value="RCP SENIA TRADING/ RCP SENIA TRANSPORT" />
                                </div>
                                <div class="form-group">
                                    <label>Net Cost</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" />
                                </div>
                                <div class="form-group">
                                    <label>Fleet Price</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">P</span>
                                        </div>
                                        <input type="text" class="form-control"  aria-label="Username" aria-describedby="basic-addon1" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Subsidy</label>
                                    <input type="text" class="form-control form-control-sm" readonly=""  />
                                </div>
                                <div class="form-group">
                                    <label>Total IPC Subsidy</label>
                                    <input type="text" class="form-control form-control-sm" readonly="" />
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

</div>
@stop


@push('scripts')
<script>

    var vm =  new Vue({
        el : "#app",
        data: {
    
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
           
        },
        mounted : function () {
           
        }
    });


   
</script>
@endpush