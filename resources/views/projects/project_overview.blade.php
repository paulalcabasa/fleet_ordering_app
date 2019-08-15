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
                                    <span class="col-md-4 kt-font-bold">Fleet Category</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.fleet_category_name }}</span>
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
                                    <span class="col-md-4 kt-font-bold">Bidding Ref No.</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_ref_no }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bid Docs Amount</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_docs_amount }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Pre-bid Schedule</span>
                                    <span class="col-md-8">@{{ projectDetails.pre_bid_sched }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bid Date Sched</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_date_sched }}</span>
                                </div> 
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bidding Venue</span>
                                    <span class="col-md-8">@{{ projectDetails.bidding_venue }}</span>
                                </div> 
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Approved Budget Cost</span>
                                    <span class="col-md-8">@{{ projectDetails.approved_budget_cost }}</span>
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
                                                <a :href="base_url + '/' + row.symlink_dir  +row.filename " download>@{{ row.orig_filename }}</a>
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
                                    <span class="col-md-8">@{{ projectDetails.email}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Website</span>
                                    <span class="col-md-8">@{{ projectDetails.website_url }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Facebook</span>
                                    <span class="col-md-8">@{{ projectDetails.facebook_url }}</span>
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
                            <th>Actions</th>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>PO Quantity</th>
                            <th>Suggested Price</th>
                      <!--       <th>Additional details</th>
                            <th>Delivery Schedule</th> -->
                        </tr>
                    </thead>

                    <tbody v-for="(vehicles,vehicle_type) in requirement">
                        <tr v-for="(row,index) in vehicles">
                            <td nowrap="nowrap">
                                <a href="#"  title="Additional details" @click="showAdditionalDetails(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-info-circle"></i></a> 
                                <a href="#"  title="Delivery schedule" @click="showDeliveryDetail(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-calendar"></i></a>
                            </td>
                            <td>@{{ row.sales_model }}</td>
                            <td><span :class="vehicle_colors[row.color]">&nbsp</span> @{{ row.color }}</td>
                            <td>@{{ row.quantity }}</td>
                            <td>@{{ row.po_qty }}</td>
                            <td>@{{ formatPrice(row.suggested_price) }}</td>
                          <!--   <td>
                                <button type="button" @click="showAdditionalDetails(row)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" @click="showDeliveryDetail(row)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-calendar"></i>
                                </button>
                            </td> -->
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
                                            <th>Isuzu Model</th> 
                                            <th>Suggested Price</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in competitors">
                                            <td>@{{ row.brand }}</td>
                                            <td>@{{ row.model }}</td>
                                            <td>@{{ formatPrice(row.price) }}</td>
                                            <td>
                                                @{{ row.sales_model }} 
                                                <span class="kt-badge kt-badge--brand kt-badge--inline">@{{ row.color}}</span>
                                            </td>
                                            <td>@{{ formatPrice(row.suggested_price) }}</td>
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
                                        <a :href="base_url + '/' + row.symlink_dir + row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>  
                    </div>
                </div>  
                <p v-if="projectDetails.competitor_flag == 'N'">@{{ projectDetails.competitor_remarks }}</p>
            </div>
        </div>
    </div>

    
    <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                @if($action == "validate")
                <button type="submit" class="btn btn-success btn-sm" @click="validateProject('approve')">Approve</button>
                <button type="submit" class="btn btn-danger btn-sm"  @click="validateProject('reject')">Reject</button>
                @elseif($action == "view")
                <button type="button" class="btn btn-danger btn-sm" @click="cancelProject()" v-if="cancel_flag">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" @click="closeProject()" v-if="projectDetails.status_name != 'Closed' && projectDetails.status_name != 'Cancelled'">Close</button>
                <!-- <button type="button" class="btn btn-primary btn-sm" @click="closeProject()">Print</button> -->
                @endif
            </div>
        </div>
    </div>
    
</div>

@if($action == "view")
    @include('projects.subform.fpc')
    @include('projects.subform.po')
    @include('projects.subform.fwpc')
@endif

<!-- delivery schedule modal -->
@include('projects.modal.delivery_schedule')
<!-- additional details modal -->
@include('projects.modal.additional_details')
<!-- price confirmation modal -->
@include('projects.modal.price_confirmation')
<!-- add fwpc modal -->
@include('projects.modal.add_fwpc')
<!-- view fwpc modal -->
@include('projects.modal.view_fwpc')
<!-- validate modal -->
@include('projects.modal.validate')
</div> 
<!-- end of app wrapper -->
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
            status_colors:          {!! json_encode($status_colors) !!},
            vehicle_colors:         {!! json_encode($vehicle_colors) !!},
            cancel_flag:            false,
            remarks:                null,
            curBodyBuilder:         null,
            curRearBody:            null,
            curAdditionalItems:     null,
            curModel:               "",
            curColor:               "",
            curQuantity:            "",
            curDeliveryDetails:     [],
            curFreebies:            [],
            curDeliverySched:       [],
            fpc:                    {!! json_encode($fpc) !!},
            po_list:                {!! json_encode($po_list) !!},
            cur_sales_order_number: '',
            cur_so_details:         [],
            cur_so_header:          [],
            cur_so_lines:           [],
            fwpc:                   {!! json_encode($fwpc) !!},
            user_type:              {!! json_encode($user_type) !!},
            display_alert : false,
            cur_fpc_project_id : ''
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
            showDetails(header_index,line_index){
                var self                = this;
                var fpc_item_id         = self.fpc[header_index]['fpc_lines'][line_index].fpc_item_id;
                var requirement_line_id = self.fpc[header_index]['fpc_lines'][line_index].requirement_line_id;
                axios.get('ajax-get-fpc-details/' + fpc_item_id + '/' + requirement_line_id)
                    .then( (response) => {
                        self.curFreebies = response.data.freebies;
                        self.curDeliverySched = response.data.delivery_sched;   
                        $("#fpc_details_modal").modal('show');
                    });
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
                axios.patch('/save-approval', {
                    approvalId : self.approvalId,
                    projectId : self.projectId,
                    remarks : self.remarks,
                    status : status
                })
                .then(function (response) {
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
                var self = this;
                Swal.fire({
                    title: 'Are you sure you want to close the project?',
                    text: "Once the project is closed, it cannot be reopened.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                          
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                    
                        axios.post('/ajax-close-project', {
                            project_id : self.projectDetails.project_id
                        })
                        .then(function (response) {
                            var data = response.data;
                            self.projectDetails.status_name = data.status;
                            KTApp.unblockPage();
                            Swal.fire({
                                type: 'success',
                                title: 'Project has been closed!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });  
            },
            cancelProject(){
                var self = this;
                Swal.fire({
                    title: 'Are you sure to cancel the project?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                    
                        axios.post('/ajax-cancel-project', {
                            project_id : self.projectDetails.project_id
                        })
                        .then(function (response) {
                            self.cancel_flag = false;
                            var data = response.data;
                            self.projectDetails.status_name = data.status;
                            KTApp.unblockPage();
                            Swal.fire({
                                type: 'error',
                                title: 'Project has been cancelled!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
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
            },
            sumQty(header_index){
                return this.fpc[header_index]['fpc_lines'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            sumPrice(header_index){
                return this.fpc[header_index]['fpc_lines'].reduce((acc,item) => parseFloat(acc) + (parseFloat(item.quantity) * (parseFloat(item.fleet_price) + parseFloat(item.freebies)) ),0);
            },
            searchSalesOrder(){
                var self = this;
                KTApp.block("#addFWPC .modal-content",{});

                axios.get('/sales-order/' + self.cur_sales_order_number + '/' + self.projectDetails.dealer_id)
                    .then( (response) => {
                        self.cur_so_details = response.data.header_data;
                        if(self.cur_so_details.length == 0){
                            self.display_alert = true;
                        }
                        else {
                            self.display_alert = false;
                        }
                        KTApp.unblock("#addFWPC .modal-content",{});
                    });
            },
            addSalesOrder(){
                var self = this;
                var isExist = self.fwpc.filter(function(elem){
                    if(
                        elem.order_number === self.cur_sales_order_number || 
                        elem.fpc_project_id === self.cur_fpc_project_id
                    ) {
                        return elem.order_number;
                    }
                });
                if(isExist == 0 ){
                    KTApp.block("#addFWPC .modal-content",{});
                    axios.post('/sales-order', {
                        project_id : self.projectDetails.project_id,
                        sales_order_id : self.cur_so_details.header_id,
                        so_number : self.cur_so_details.order_number,
                        fpc_project_id : self.cur_fpc_project_id
                    }).then( (response) => {
                        KTApp.unblock("#addFWPC .modal-content",{});
                        $("#addFWPC").modal('hide');
                        self.fwpc.push(response.data);
                        self.cur_so_details = [];
                        self.cur_sales_order_number = '';
                    });
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: "FWPC already exist for this FPC",
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                }
            },
            deleteFwpc(index){
                var self = this;

                Swal.fire({
                    title: 'Are you sure to delete this FWPC?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                        
                        axios.delete('/fwpc/' + self.fwpc[index].fwpc_id)
                        .then(function (response) {
                            self.fwpc.splice(index,1);
                            KTApp.unblockPage();
                            Swal.fire({
                                type: 'error',
                                title: 'FWPC has been deleted!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });  
            },
            viewFwpc(index){
                var self = this;
                self.cur_so_header = [];
                self.cur_so_lines = [];
                $("#viewFWPC").modal('show');
                KTApp.block("#viewFWPC .modal-content",{});
                axios.get('/sales-order-data/' + this.fwpc[index].fwpc_id)
                    .then( (response) => {
                        self.cur_so_header = response.data.so_header;
                        self.cur_so_lines = response.data.so_lines;
                        KTApp.unblock("#viewFWPC .modal-content",{});
                    });
            },
            addFWPCModal(fpc_project_id){
                this.cur_fpc_project_id = fpc_project_id;
                $("#addFWPC").modal('show');
            }
        },
        created: function () {
            // `this` points to the vm instance
            var self = this;
            if(self.projectDetails.status_name == 'New'){
                self.cancel_flag = true;
            }
        },
        mounted : function () {
            
        },
        filters: {
            formatPeso: function (value) {
                 return `${parseFloat(value).toLocaleString()}`
            }
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
            },
            sumFreebies(){
                return this.curFreebies.reduce((acc,item) => parseFloat(acc) + parseFloat(item.amount),0);
            }
        }
        
    });
</script>
@endpush