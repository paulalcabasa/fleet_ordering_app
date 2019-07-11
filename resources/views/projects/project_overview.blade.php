@extends('_layouts.metronic')

@section('page-title', 'Project Overview')

@section('content')

<div id="app"> <!-- start of app wrapper -->

<div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Details
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-pills nav-pills-sm" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#account" role="tab" aria-selected="true">
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-selected="false">
                        Contact Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#requirement" role="tab" aria-selected="false">
                        Requirement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#competitors" role="tab" aria-selected="false">
                        Competitors
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#terms" role="tab" aria-selected="false">
                        Terms and Conditions
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="account">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">
                                Project Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Project No.</span>
                                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ projectDetails.project_id }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Dealer</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">
                                    @{{ projectDetails.dealer_name }} - @{{ projectDetails.dealer_account}}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Fleet Account Name</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.fleet_account_name }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Project Source</span>
                                    <span class="col-md-8">@{{ projectDetails.project_source }}</span>
                                </div>
                               
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Date Submitted</span>
                                    <span class="col-md-8">@{{ projectDetails.date_created }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Status</span>
                                    <span class="col-md-8">
                                        <span :class="status_colors[projectDetails.status_name]">@{{ projectDetails.status_name }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card" v-if="projectDetails.bid_ref_no">
                            <div class="card-header">
                                Bidding Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-header">
                                Customer Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Organization Type</span>
                                    <span class="col-md-8">@{{ customerDetails.org_type_name }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">TIN</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ customerDetails.tin }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Address</span>
                                    <span class="col-md-8">@{{ customerDetails.address }}</span>
                                </div>
                                <div class="row kt-margin-b-5" v-if="attachments.length > 0">
                                    <span class="col-md-4 kt-font-bold">Attachment</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in attachments">
                                                <a :href="base_url + '/' + row.directory + '/' +row.filename " download>@{{ row.orig_filename }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Business Style</span>
                                    <span class="col-md-8">@{{ customerDetails.business_style }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Date of Establishment</span>
                                    <span class="col-md-8">@{{ customerDetails.establishment_date }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Affiliates</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in affiliates">
                                                <a href="#">@{{ row.customer_name }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Products</span>
                                    <span class="col-md-8">@{{ customerDetails.products }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Company Overview</span>
                                    <span class="col-md-8">@{{ customerDetails.company_overview }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                
            </div>
            <div class="tab-pane" id="contact">

                <div class="card kt-margin-b-10">
                    <div class="card-header">
                        Customer Contact Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Contact No.</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in contacts">@{{ row.contact_number }}</li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Email</span>
                                    <span class="col-md-8"><a href="mailto:xxx@xxx.mail">@{{ projectDetails.email}}</a></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Website</span>
                                    <span class="col-md-8"><a href="http://www.website.com">@{{ projectDetails.website_url }}</a></span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Facebook</span>
                                    <span class="col-md-8"><a href="http://www.facebook.com">@{{ projectDetails.facebook_url }}</a></span>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
                
             
                <div class="card kt-margin-b-10">
                    <div class="card-header">
                        Contact Persons
                    </div>
                    <div class="card-body">
                         <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in contactPersons">
                                    <td>@{{ row.name }}</td>
                                    <td>@{{ row.position_title }}</td>
                                    <td>@{{ row.department }}</td>
                                    <td>@{{ row.contact_number }}</td>
                                    <td>@{{ row.email_address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
             
                <div class="card">
                    <div class="card-header">Dealer Sales Executives</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>  
                                    <th>Mobile No.</th>  
                                    <th>Email</th>  
                                    <th></th>  
                                </tr>
                            </thead> 
                            <tbody>
                                <tr v-for="(row, index) in salesPersons">
                               
                                    <td>@{{ row.name }}</td>
                                    <td>@{{ row.position }}</td> 
                                    <td>@{{ row.mobile_no }}</td> 
                                    <td>@{{ row.email_address }}</td> 
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
              
            </div>
            <div class="tab-pane" id="requirement">
                <table class="table table-condensed"  style="font-size:90%;">
                    <thead>
                        <tr class="kt-font-bold bg-light-gray-1">
                            <th>Model</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>PO Quantity</th>
                            <th>Suggested Price</th>
                            <th>Additional details</th>
                            <th>Delivery Schedule</th>
                        </tr>
                    </thead>

                    <tbody v-for="(vehicles,vehicle_type) in requirement">
                        <tr v-for="(row,index) in vehicles">
                            <td>@{{ row.sales_model }}</td>
                            <td>@{{ row.color }}</td>
                            <td>@{{ row.quantity }}</td>
                            <td>@{{ row.po_qty }}</td>
                            <td>@{{ formatPrice(row.suggested_price) }}</td>
                            <td>
                                <button type="button" @click="showAdditionalDetails(row)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" @click="showDeliveryDetail(row)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-calendar"></i>
                                </button>
                            </td>
                        </tr>

                        <tr class="kt-font-bold bg-light-gray-1">
                           <th colspan="2">@{{ vehicle_type }}</th>
                           <th>@{{ sumOrderQty(vehicle_type) }}</th> 
                           <th>@{{ sumPOQty(vehicle_type) }}</th> 
                           <th colspan="3">@{{ formatPrice(sumSuggestedPrice(vehicle_type)) }}</th> 
                        </tr>
                   
                    </tbody>

                    <tfoot>
                        <tr class="bg-light-gray-2">
                            <th colspan="2">Grand Total</th>
                            <th>@{{ totalQty }}</th>
                            <th>@{{ totalPOQty }}</th>
                            <th colspan="3">@{{ formatPrice(totalSuggestedPrice) }}</th>
                        </tr>
                    </tfoot>
                </table>
               
            </div>
            <div class="tab-pane" id="competitors">
                <div class="row" v-if="projectDetails.competitor_flag == 'Y'">
                    <div class="col-md-8" v-if="competitors.length > 0">
                        <div class="card">
                            <div class="card-header">Vehicles</div>
                            <div class="card-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Price</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in competitors">
                                            <td>@{{ row.brand }}</td>
                                            <td>@{{ row.model }}</td>
                                            <td>@{{ formatPrice(row.price) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" v-if="competitor_attachments.length > 0">
                        <div class="card">
                            <div class="card-header">Attachment</div>
                            <div class="card-body">
                                <ul style="list-style:none;padding:0;">
                                    <li v-for="(row,index) in competitor_attachments">
                                        <a :href="base_url + '/' + row.directory + '/' +row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                    </div>
                </div>  
                <p v-if="projectDetails.competitor_flag == 'N'">@{{ projectDetails.competitor_remarks }}</p>
            </div>
            <div class="tab-pane" id="terms">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Price Validity</span>
                    <span class="col-md-8">May 31, 2019</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Deadline of Submission</span>
                    <span class="col-md-8">May 31, 2019</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Payment Terms</span>
                    <span class="col-md-8">Strictly C.O.D only</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                @if($action == "validate")
                <button type="submit" class="btn btn-success" @click="validateProject('approve')">Approve</button>
                <button type="submit" class="btn btn-danger"  @click="validateProject('reject')">Reject</button>
                @elseif($action == "cancel")
                <a href="#"class="btn btn-danger">
                    <span class="kt-hidden-mobile">Cancel</span>
                </a>
                @elseif($action == "view")
                <button type="button" class="btn btn-danger" @click="closeProject()">Cancel</button>
                <button type="button" class="btn btn-success" @click="closeProject()">Close</button>
                <button type="button" class="btn btn-primary" @click="closeProject()">Print</button>
                @endif
            </div>
        </div>
    </div>
    
</div>

@if($action == "view")
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Price Confirmation 
            </h3> 
        </div>
      
    </div>

    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>FPC No.</th>
                    <th>Account Name</th>
                    <th>Date Confirmed</th>
                    <th>Confirmed By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fpc"> 
                    <td>@{{ row.fpc_no }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.date_confirmed }}</td>
                    <td>@{{ row.confirmed_by }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="{{ url('view-fpc/001')}}" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Purchase Order
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ url('/manage-po/create/001')}}" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">Submit PO</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>PO Ref</th>
                    <th>PO No.</th>
                    <th>Submitted By</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in po"> 
                    <td>@{{ row.po_ref_no }}</td>
                    <td>@{{ row.po_no }}</td>
                    <td>@{{ row.submitted_by }}</td>
                    <td>@{{ row.date_submitted }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Wholesale Price Confirmation
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>Sales Order No.</th>
                    <th>Ordered Date</th>
                    <th>Customer Name</th>
                    <th>Order Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fwpc"> 
                    <td>@{{ row.oracle_so_num }}</td>
                    <td>@{{ row.ordered_date }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td>@{{ row.order_type }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        




    </div>
</div>

@endif;

<!--begin::Modal-->
<div class="modal fade" id="deliveryScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="details-item">
                                    <span class="details-label">Model</span>
                                    <span class="details-subtext">@{{ curModel }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Color</span>
                                    <span class="details-subtext">@{{ curColor }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Quantity</span>
                                    <span class="details-subtext">@{{ curQuantity}}</span>
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
                                <tr v-for="(row,index) in curDeliveryDetails">
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ row.delivery_date }}</td>
                                </tr>
                            
                            </tbody>
                        </table>                    
                    </div>
                </div>
    
            </div>
           <!--  <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add row</button>
            </div> -->
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="details-item">
                    <span class="details-label">Name of Body Builder</span>
                    <span class="details-subtext">@{{ curBodyBuilder == null ? '-' : curBodyBuilder }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Rear Body Type</span>
                    <span class="details-subtext">@{{ curRearBody == null ? '-' : curRearBody  }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Additional Items</span>
                    <span class="details-subtext">@{{ curAdditionalItems == null ? '-' : curAdditionalItems  }}</span>
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
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">          
                <div class="form-group">
                    <label>Are you sure to cancel this project? Kindly state your reason.</label>
                    <textarea class="form-control" v-model="remarks"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="confirmReject" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


</div> <!-- end of app wrapper -->
@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            approvalId:             {!! json_encode($approval_id) !!},
            projectId:              {!! json_encode($project_id) !!},
            projectDetails:         {!! json_encode($project_details) !!},
            customerDetails:        {!! json_encode($customer_details) !!},
            attachments:            {!! json_encode($attachments) !!},
            affiliates:             {!! json_encode($affiliates) !!},
            contacts:               {!! json_encode($contacts) !!},
            contactPersons:         {!! json_encode($contact_persons) !!},
            salesPersons:           {!! json_encode($sales_persons) !!},
            requirement:            {!! json_encode($requirement) !!},
            competitors:            {!! json_encode($competitors) !!},
            base_url:               {!! json_encode($base_url) !!},
            competitor_attachments: {!! json_encode($competitor_attachments) !!},
            remarks:                null,
            curBodyBuilder:         null,
            curRearBody:            null,
            curAdditionalItems:     null,
            curModel:               "",
            curColor:               "",
            curQuantity:            "",
            curDeliveryDetails:     [],
            status_colors : {
                'New' : "kt-badge kt-badge--brand kt-badge--inline",
                'Acknowledged' : "kt-badge kt-badge--success kt-badge--inline",
                'Submitted' : "kt-badge kt-badge--warning kt-badge--inline",
                'Cancelled' : "kt-badge kt-badge--danger kt-badge--inline",
            },
            fpc:                    [
                {
                    fpc_no : "FPC001",
                    account_name : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    date_confirmed : "May 22, 2019",
                    confirmed_by : "Paul Alcabasa",
                    status : "Approved"

                }
            ],
            po : [
                {
                    po_ref_no : 'PO001',
                    po_no : 'CUSTPO11',
                    submitted_by : 'Mary Jan Watson',
                    date_submitted : 'May 23, 2019',
                    status : 'Approved'
                }
            ],
            fwpc : [
                {
                    oracle_so_num : "3010000123",
                    ordered_date : "May 30, 2019",
                    customer_name : "ISUZU AUTOMOTIVE DEALERSHIP, INC.",
                    order_type : "FLT.Sales Order (LCV A)",
                    status : "Booked"
                }
            ]
        },
        methods : {
            showDeliveryDetail(data){
                var self = this;

                self.curModel = data.sales_model;
                self.curColor = data.color;
                self.curQuantity = data.quantity;
                axios.get('/ajax-get-delivery-detail/' + data.requirement_line_id)
                    .then(function (response) {
                        self.curDeliveryDetails = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
                $("#deliveryScheduleModal").modal('show');
            },
            showAdditionalDetails(row){
                this.curBodyBuilder = row.body_builder_name;
                this.curRearBody = row.rear_body_type;
                this.curAdditionalItems = row.additional_items;
                $("#additionalDetailsModal").modal('show');
            },
            confirmReject(){
                this.submitApproval('reject', 'error', 'Project has been rejected.')
            },
            validateProject(status){
                var self = this;
                if(status == 'approve'){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This operation will approve the project.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.value) {
                            this.submitApproval(status, 'success', 'Project has been approved!');                            
                        }
                    });
                }
                else {
                    $("#rejectModal").modal('show');
                }
            },
            submitApproval(status, swal_type, swal_title){
                var self = this;
                axios.post('/save-approval', {
                    approvalId : self.approvalId,
                    projectId : self.projectId,
                    remarks : self.remarks,
                    status : status
                })
                .then(function (response) {
                    console.log(response);
                    Swal.fire({
                        type: swal_type,
                        title: swal_title,
                        showConfirmButton: false,
                        timer: 1500,
                        onClose : function(){
                            window.location.href = "{{ url('all-projects')}}";
                        }
                    });

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            closeProject(){
                Swal.fire({
                    type: "success",
                    title: "Successfully closed the project!",
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-projects')}}";
                    }
                });
            },
            sumOrderQty(vehicle_type){
                return this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            sumPOQty(vehicle_type){
                return this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.po_qty),0);
            },
            sumSuggestedPrice(vehicle_type){
                return this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.suggested_price),0);
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
        computed : {
            totalQty : function(){
                var total = 0;
                for(vehicle_type in this.requirement){
                    total += this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
                }
                return total;
            },
            totalPOQty : function(){
                var total = 0;
                for(vehicle_type in this.requirement){
                    total += this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.po_qty),0);
                }
                return total;
            },
            totalSuggestedPrice : function(){
                var total = 0;
                for(vehicle_type in this.requirement){
                    total += this.requirement[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.suggested_price),0);
                }
                return total;
            }
        }
        
    });
</script>
@endpush