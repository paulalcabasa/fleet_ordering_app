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
            <a href="#" class="btn btn-success btn-sm kt-margin-r-5" @click="approveFPC()" v-if="editable">
                <span class="kt-hidden-mobile">Approve</span>
            </a>
            <a href="#" class="btn btn-sm btn-danger" @click="cancelFPC()" v-if="editable">
                <span class="kt-hidden-mobile">Cancel</span>
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
                        <span :class="status_colors[fpc_details.status_name]">@{{ fpc_details.status_name }}</span>
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
                <div class="row kt-margin-b-5" v-if="!editable">
                    <span class="col-md-4 kt-font-bold">Remarks</span>
                    <span class="col-md-8">@{{ fpc_details.remarks }}</span>
                </div>
                <div class="row kt-margin-b-5" v-if="fpc_attachments.length > 0">
                    <span class="col-md-4 kt-font-bold">Attachment</span>
                    <span class="col-md-8">
                        <ul style="list-style:none;padding:0;">
                            <li v-for="(row,index) in fpc_attachments">
                                <a :href="baseURL + '/' + row.symlink_dir  +row.filename " download>@{{ row.orig_filename }}</a>
                            </li>
                        </ul>    
                    </span>
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
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="'#terms_tab_' + index" role="tab" aria-selected="false">
                        Terms and Conditions
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
                            <th>Actions</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Order Qty</th>
                            <th>Suggested Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in project.requirements">
                            <td nowrap="nowrap">
                                <a href="#"  title="View"  @click.prevent="priceConfirmation(order,project.dealer_account)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="fas fa-money-bill-wave"></i></a> 
                                <a href="#"  title="View"  @click="showAdditionalDetails(order)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-info-circle"></i></a> 

                              
                            </td>
                        <!--     <td nowrap>
                                <a href="#" @click.prevent="priceConfirmation(order,project.dealer_account)" class="btn btn-primary btn-sm btn-icon btn-circle"><i class="fas fa-money-bill-wave"></i></a>
                                <a href="#" @click="showAdditionalDetails(order)" class="btn btn-success btn-sm btn-icon btn-circle"><i class="la la-info-circle"></i></a> 
                            </td> -->
                            <td> @{{ order.sales_model }} </td>
                            <td> @{{ order.color }} </td>
                            <td> @{{ order.quantity }} </td>
                            <td> @{{ formatPrice(order.suggested_price) }} </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" :id="'competitors_tab_'+ index">
                <div class="row" v-if="project.competitor_flag == 'Y'">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Vehicles</div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" style="font-size:85%;">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Price</th>
                                            <th>Isuzu Model</th>
                                            <th>Suggested Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(competitor, index) in project.competitors">
                                            <td> @{{ competitor.brand }} </td>
                                            <td> @{{ competitor.model }} </td>
                                            <td> @{{ formatPrice(competitor.price) }} </td>
                                            <td> 
                                                @{{ competitor.sales_model }} 
                                                <span class="kt-badge kt-badge--brand kt-badge--inline">@{{ competitor.color }}</span>
                                            </td>
                                            <td> @{{ formatPrice(competitor.suggested_price) }} </td>
                                        </tr>
                                    </tbody>
                                </table>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" v-if="project.competitor_attachments.length > 0">
                        <div class="card">
                            <div class="card-header">Attachment</div>
                            <div class="card-body">
                                <ul style="list-style:none;padding:0;">
                                    <li v-for="(row,index) in project.competitor_attachments">
                                        <a :href="baseURL + '/' + row.directory + '/' +row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                    </div>
                </div>
                <p v-if="project.competitor_flag == 'N'">@{{ project.competitor_remarks }}</p>
            </div>
            <div class="tab-pane" :id="'terms_tab_'+ index">

                <!-- Form for filling up Terms and conditions -->
                <form v-if="editable">
                    <div class="form-group row" style="margin-bottom:.5em !important;">
                        <div class="col-md-6">
                            <label class="col-form-label">Payment Terms</label>
                            <select class="form-control" v-model="project.payment_terms" v-select style="width:100%;">
                                <option value="-1">Choose payment term</option>
                                <option v-for="(row,index) in payment_terms" :value="row.term_id">@{{ row.term_name }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Validity</label>
                            <input type="date" class="form-control" v-model.lazy="project.validity" />
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom:.5em !important;">
                        <div class="col-md-6">
                            <label class="col-form-label">Availability</label>
                            <input type="text" class="form-control" v-model.lazy="project.availability">
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Note</label>
                            <textarea class="form-control" v-model.lazy="project.note"></textarea>
                        </div>
                    </div>
                </form>
                <!-- end of form -->

                <!-- only show when status is approved -->
                <div class="row" v-if="!editable">
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Payment Terms</span>
                            <span class="col-md-8">@{{ project.term_name }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Validity</span>
                            <span class="col-md-8">@{{ project.validity_disp }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Availability</span>
                            <span class="col-md-8">@{{ project.availability }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Note</span>
                            <span class="col-md-8">@{{ project.note }}</span>
                        </div>
                    </div>
                </div>
                <!-- only show when status is approved -->
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
         <div class="row  kt-pull-right">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary btn-sm" @click="printFPC(index)">Print</button>
                <button type="button" class="btn btn-success btn-sm" @click="saveTerms(index)"  v-if="editable">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="priceConfirmationModal" style="z-index:1050" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-5">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">Item Detail</div>
                            <div class="card-body" style="font-size:90%;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="details-item">
                                            <span class="details-label">Project No.</span>
                                            <span class="details-subtext">@{{ curModel.project_id }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Account Name</span>
                                            <span class="details-subtext">@{{ customer_details.customer_name}}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Dealer</span>
                                            <span class="details-subtext">@{{ curDealerAccount }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">@{{ curModel.sales_model }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">@{{ curModel.quantity }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Suggested Price</span>
                                            <span class="details-subtext">@{{ formatPrice(curModel.suggested_price) }}</span>
                                        </div> 

                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Freebies</div>
                            <div class="card-body">
                                <!-- Form for entering freebies -->
                                <table class="table table-condensed" style="font-size:90%;" v-if="editable">
                                    <thead>
                                        <th></th>
                                        <th>Item</th>
                                        <th>Amount</th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(freebie, index) in curFreebies" v-show="freebie.deleted != 'Y'">
                                            <td>
                                                <a href="#" @click.prevent="deleteRow(freebie,index)">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                            <td v-if="freebie.hasOwnProperty('freebie_id')"><input type="text" disabled="" class="form-control form-control-sm" :value="freebie.description"/></td>
                                            <td v-if="!freebie.hasOwnProperty('freebie_id')"><input type="text" class="form-control form-control-sm" v-model.lazy="freebie.description"/></td>
                                            <td><input type="text" class="form-control form-control-sm" v-model="freebie.amount" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- End for form for entering freebies -->

                                <!-- table for viewing only freebies -->
                                <table class="table table-condensed" style="font-size:90%;" v-if="!editable">
                                    <thead>
                                        <th>No.</th>
                                        <th>Item</th>
                                        <th>Amount</th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(freebie, index) in curFreebies" v-show="freebie.deleted != 'Y'">
                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ freebie.description }}</td>
                                            <td>@{{ formatPrice(freebie.amount) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- table for viewing only freebies -->
                            </div>
                            <div class="card-footer" v-if="editable">
                                <button type="button" class="btn btn-primary btn-sm"  @click="addRow()">Add</button>
                            </div>
                        </div>          
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">Pricing</div>
                            <div class="card-body">

                                <!-- form for entering pricing details -->
                                <form class="form-horizontal" v-if="editable">
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">SRP</label>
                                        <div class="col-lg-9">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm" 
                                                :value="formatPrice(curModel.suggested_retail_price)"
                                                disabled="disabled" 
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Wholesale Price</label>
                                        <div class="col-lg-9">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm" 
                                                :value="formatPrice(calculateWSP)" 
                                                disabled="disabled" 
                                            />
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
                                        <label class="col-lg-3 col-form-label">Subsidy per unit</label>
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
                               <!-- end of form for entering pricing details -->

                               <!-- Viewing of pricing details -->
                               <div v-if="!editable">
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">SRP</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.suggested_retail_price)}}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Wholesale Price</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(calculateWSP) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Dealer's Margin</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateMargin)}}  (@{{ curModel.dealers_margin }}%)</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">3 Yrs LTO Registration</span>
                                        <span class="col-md-8">@{{ formatPrice(curModel.lto_registration) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Freebies</span>
                                        <span class="col-md-8">@{{ formatPrice(sumFreebies) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Cost</span>
                                        <span class="col-md-8 kt-font-bold kt-font-danger">@{{ formatPrice(calculateCost) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Net Cost</span>
                                        <span class="col-md-8 kt-font-bold kt-font-primary">@{{ formatPrice(calculateNetCost) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Fleet Price</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.fleet_price) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Subsidy</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateSubsidy) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Total IPC Subsidy</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateTotalSubsidy) }}</span>
                                    </div>
                                </div>
                               <!-- end of viewing of pricing details -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"  v-if="editable">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-success" @click="saveFPCItem()">Save</button>
              <!--   <a href="#" @click.prevent="printPrintConfirmation(project_id)" class="btn btn-primary">Print</a> -->
               <!--  <button type="button" v-if="active_tab == 1" class="btn btn-primary" @click="addRow()">Add row</button> -->
            </div>
        </div>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@{{ curModel.sales_model }} - @{{ curModel.color }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-header">Additional Details</div>
                            <div class="card-body">
                                <div class="details-item">
                                    <span class="details-label">Name of Body Builder</span>
                                    <span class="details-subtext">@{{ curModel.body_builder_name  }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Rear Body Type</span>
                                    <span class="details-subtext">@{{ curModel.rear_body_type }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Additional Items</span>
                                    <span class="details-subtext">@{{ curModel.additional_items }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Delivery Schedule</div>
                            <div class="card-body">
                                 <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <td>Date</td>
                                            <td>Quantity</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliveryDetails">
                                            <td>@{{ row.delivery_date}}</td>
                                            <td>@{{ row.quantity }}</td>
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

<!--begin::Modal-->
<div class="modal fade" id="fpcApprovalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="kt-font-transform-c">@{{ action }}</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="form-group" v-if="action == 'approve'">
                    <label>Attach signed copy of FPC</label>
                    <div></div>
                    <div class="custom-file">
                        <input type="file"   @change="validateFileSize('fpc')" class="custom-file-input" ref="customFile" name="fpc_attachment[]" id="fpc_attachment" multiple="true">
                        <label class="custom-file-label" for="attachment">@{{ fpc_attachment_label }}</label>
                         <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                            <li v-for="(row,index) in fpc_attachment">
                                <span>@{{ row.orig_filename }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <span v-if="action == 'approve'">Remarks</span>
                        <span v-if="action == 'cancel'">Are you sure to cancel the FPC? Please state your reason.</span>
                    </label>
                    <textarea class="form-control" v-model.lazy="remarks"></textarea> 
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-if="action == 'approve'" @click="confirmApproval()">Confirm</button>
                <button type="button" class="btn btn-success" v-if="action == 'cancel'" @click="confirmCancellation()">Confirm</button>
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
            fpc_details:          {!! json_encode($fpc_details) !!},
            customer_details:     {!! json_encode($customer_details) !!},
            projects:             {!! json_encode($projects) !!},
            payment_terms:        {!! json_encode($payment_terms) !!},
            baseURL:              {!! json_encode($base_url) !!} ,
            editable:              {!! json_encode($editable) !!} ,
            fpc_attachments:              {!! json_encode($fpc_attachments) !!} ,
            curModel:             [],
            curDealerAccount:     '',
            curFreebies:          [],
            curDeliveryDetails:   [],
            active_tab:           0,
            fpc_attachment:       [],
            fpc_attachment_label: 'Choose file',
            remarks: '',
            action : '',
            status_colors : {
                'New' : "kt-badge kt-badge--brand kt-badge--inline",
                'Acknowledged' : "kt-badge kt-badge--success kt-badge--inline",
                'Approved' : "kt-badge kt-badge--success kt-badge--inline",
                'Submitted' : "kt-badge kt-badge--warning kt-badge--inline",
                'Cancelled' : "kt-badge kt-badge--danger kt-badge--inline",
                'In progress' : "kt-badge kt-badge--warning kt-badge--inline"
            },
        },
        methods : {
            cancelFPC(){
                $("#fpcApprovalModal").modal('show');
                this.action = "cancel";
            },
            confirmCancellation(){
                var self = this;
                KTApp.block("#fpcApprovalModal .modal-content",{
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                })
                axios.post('ajax-cancel-fpc',{
                    fpc_id : self.fpc_details.fpc_id
                }).then( (response) => {
                    KTApp.unblock("#fpcApprovalModal .modal-content",{});
                    self.toast('error','FPC has been cancelled.');
                    self.fpc_details.status_name = response.data.status;
                    self.editable = response.data.editable;
                    $("#fpcApprovalModal").modal('hide');
                }); 
            },
            approveFPC(){
                this.action = "approve";
                $("#fpcApprovalModal").modal('show');
            },
            confirmApproval(){

                let data = new FormData();
                var self = this;
                data.append('fpc_id',self.fpc_details.fpc_id);
                data.append('remarks',self.remarks);

                $.each($("#fpc_attachment")[0].files, function(i, file) {
                    data.append('fpc_attachment[]', file);
                });

                KTApp.block("#fpcApprovalModal .modal-content",{
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                })

                axios.post('/ajax-approve-fpc',data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    KTApp.unblock("#fpcApprovalModal .modal-content",{});
                    self.toast('success','FPC has been approved!');
                    $("#fpcApprovalModal").modal('hide');
                    self.fpc_details.status_name = response.data.status;
                    self.editable = response.data.editable; 
                });

            },
            saveTerms(index){
                var self = this;
                var project = self.projects[index];

                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.post('ajax-save-terms', {
                    fpc_project_id: project.fpc_project_id,
                    payment_terms:  project.payment_terms,
                    validity:       project.validity,
                    availability:   project.availability,
                    note:           project.note
                }).then((response) => {
                    KTApp.unblockPage();
                    self.toast('success','Saved data.'); 
                });
            },  
            priceConfirmation(order,dealerAccount){
                var self = this;
                self.curModel = order;
                self.curDealerAccount = dealerAccount;
                axios.get('/ajax-get-freebies/' + self.curModel.fpc_item_id)
                    .then( (response) => {
                        self.curFreebies = response.data;
                    });
                $("#priceConfirmationModal").modal('show');
            },
            addRow(){
                var self = this;
                var fpc_item_id = self.curModel.fpc_item_id;
                self.curFreebies.push(
                    {
                        fpc_item_id : fpc_item_id,
                        description : "",
                        amount : 0     
                    }
                ); 
            },
            toast(type,message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                });

                Toast.fire({
                    type: type,
                    title: message
                });
            },
            deleteRow(freebie,index){
                var self = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        if(freebie.hasOwnProperty('freebie_id')){
                            // mark as deleted to database
                            self.curFreebies[index].deleted = 'Y';
                            self.curFreebies[index].amount = 0;
                        }
                        else {
                            // delete from object only
                            this.curFreebies.splice(index,1);
                        }        
                    }
                });                 
            },
            saveFPCItem(){
                var self = this;
                axios.post('ajax-save-fpc-item', {
                    modelData : self.curModel,
                    freebies : self.curFreebies
                }).then((response) => {
                    $("#priceConfirmationModal").modal('hide');
                    self.toast('success','Saved data.');
                });
            },
            updateActiveTab(tab_id){
                this.active_tab = tab_id;
            },
            printPrintConfirmation(id){
                window.open(baseURL + '/print-fpc');
            },
            showAdditionalDetails(order){
                this.curModel = order;
                var self = this;
                axios.get('/ajax-get-delivery-detail/' + this.curModel.requirement_line_id)
                    .then((response) => {
                        this.curDeliveryDetails = response.data;
                    });
                $("#additionalDetailsModal").modal('show');
            },
            formatPrice(value){
                return (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            },
            validateFileSize(attachment_type){
                var self = this;
                var total_size = 0;
                var total_files = 0;
                
                self.fpc_attachment = [];

                if(attachment_type == "fpc"){

                    $.each($("#fpc_attachment")[0].files, function(i, file) {
                        total_size += file.size;  
                        self.fpc_attachment.push({
                            directory : null,
                            filename : file.name,
                            orig_filename : file.name
                        });
                        total_files++;
                    });
                }
               

                var total_size_mb = total_size / 1024 / 1024;
                if(total_size_mb >= 10){
                    Swal.fire({
                        type: 'error',
                        title: 'Attachment must be less than 10mb.',
                        showConfirmButton: true
                    });

                    if(attachment_type == "fpc"){
                        $("#fpc_attachment").val("");
                        self.fpc_attachment = [];
                    }
                    
                }
                else {
                   
                    if(attachment_type == "fpc"){
                        self.fpc_attachment_label = total_files + " file" + (total_files > 1 ? "s" : "") + " selected" ;
                   }
                }
            },
            printFPC(index){
                //console.log(this.projects[index].fpc_project_id);
                window.open(this.baseURL + '/print-fpc/' + this.projects[index].fpc_project_id);    
            }
        },
        created: function () {
            // `this` points to the vm instance
        },
        mounted : function () {
          
        },
        computed: {
            sumFreebies(){
                return this.curFreebies.reduce((acc,item) => parseFloat(acc) + parseFloat(item.amount),0);
            },
            calculateCost(){
                return (parseFloat(this.curModel.suggested_retail_price) + parseFloat(this.calculateMargin) + parseFloat(this.sumFreebies));
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
            },
            calculateWSP(){
                return parseFloat(this.curModel.suggested_retail_price) - (parseFloat(this.curModel.suggested_retail_price) * (this.curModel.dealers_margin/100));
            }
        }
    });
</script>
@endpush