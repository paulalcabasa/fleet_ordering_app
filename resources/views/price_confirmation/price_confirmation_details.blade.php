@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="row">
    <div :class="conflicts.length > 0 ? 'col-md-8' : 'col-md-12'">
        <div class="kt-portlet kt-portlet--responsive-mobile" id="kt_page_portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Details</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="#" class="btn btn-success btn-sm kt-margin-r-5" @click="approveFPC()" v-if="editable">
                        <span class="kt-hidden-mobile">Approve</span>
                    </a>
                    <a href="#" class="btn btn-sm btn-danger kt-margin-r-5" @click="cancelFPC()" v-if="editable">
                        <span class="kt-hidden-mobile">Cancel</span>
                    </a>
                    <a  class="btn btn-sm btn-primary kt-margin-r-5" href="{{ url('print-fpc-conflict/' . $price_confirmation_id ) }}" target="_blank">
                        <span class="kt-hidden-mobile">Print Conflict</span>
                    </a>
                
            <!--       <div class="btn-group">
                        <button type="button" class="btn btn-brand btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Info</button>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                            <a class="dropdown-item" href="#">LCV</a>
                            <a class="dropdown-item" href="#">CV</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </div> -->
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
    </div>

    <div class="col-md-4" v-if="conflicts.length > 0">
        <div class="kt-portlet kt-portlet--last  kt-portlet--responsive-mobile" >
            <div class="kt-portlet__head" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Conflicting Models</h3>
                </div>
            </div>
            <div class="kt-portlet__body"> 
                <ul v-for="row in conflicts" style="list-style-type:none;padding:0;margin:0;">
                    <li><i class="flaticon2-right-arrow"></i> @{{ row.sales_model }}</li>
                </ul>
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
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="'#details_tab_' + index" role="tab" aria-selected="false">
                        Details
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" :id="'orders_tab_' + index">
                <div class="table-responsive">
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
                            <tr v-for="(order, requirementIndex) in project.requirements">
                                <td nowrap="nowrap">
                                    <a href="#"  title="View"  @click.prevent="priceConfirmation(order,project.dealer_account,index,requirementIndex)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="fas fa-money-bill-wave"></i></a> 
                                    <a href="#"  title="Show details"  @click="showAdditionalDetails(order)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-info-circle"></i></a> 
                                </td>
                                <td> @{{ order.sales_model }} </td>
                                <td> @{{ order.color }} </td>
                                <td> @{{ order.quantity }} </td>
                                <td> @{{ formatPrice(order.suggested_price) }} </td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" :id="'competitors_tab_'+ index">
                <div class="row" v-if="project.competitor_flag == 'Y'">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Vehicles</div>
                            <div class="card-body">
                                <div class="table-responsive">
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
                            <select class="form-control" v-model="project.payment_terms" v-select style="width:100%;" id="sel_payment_term">
                                <option value="">Choose payment term</option>
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
            <div class="tab-pane" :id="'details_tab_' + index">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Project No.</span>
                            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ project.project_id }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Project Status</span>
                            <span class="col-md-8">
                                <span :class="status_colors[project.project_status]">@{{ project.project_status }}</span>
                            </span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">FPC Project Status</span>
                            <span class="col-md-8">
                                <span :class="status_colors[project.fpc_prj_status]">@{{ project.fpc_prj_status }}</span>
                            </span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">FPC Project Ref No.</span>
                            <span class="col-md-8">@{{ project.fpc_project_id }}</span>
                        </div>      
                        <div class="row kt-margin-b-5" v-if="project.fpc_project_attachments.length > 0">
                            <span class="col-md-4 kt-font-bold">Attachment</span>
                            <span class="col-md-8">
                                <ul style="list-style:none;padding:0;">
                                    <li v-for="(row,index) in project.fpc_project_attachments">
                                        <a :href="baseURL + '/' + row.symlink_dir  +row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>    
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
         <div class="row  kt-pull-right">
            <div class="col-lg-12">
                <button type="button" class="btn btn-danger btn-sm" @click="cancelProject(index)" v-if="project.project_status != 'Cancelled'">Cancel</button>
                <button type="button" class="btn btn-secondary btn-sm" @click="printFPC(index)">Print</button>
                <button type="button" class="btn btn-primary btn-sm" @click="showAttachmentModal(index)" v-if="editable">Attach files</button>
                <button type="button" class="btn btn-success btn-sm" @click="saveTerms(index)" v-if="editable">Save</button>
            </div>
        </div>
    </div>
</div>

@include('price_confirmation.modal.price_details')

@include('price_confirmation.modal.approval')

@include('price_confirmation.modal.additional_details')

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
            conflicts:            {!! json_encode($conflicts) !!},
            baseURL:              {!! json_encode($base_url) !!} ,
            editable:             {!! json_encode($editable) !!} ,
            fpc_attachments:      {!! json_encode($fpc_attachments) !!} ,
            vehicle_lead_time:    {!! json_encode($vehicle_lead_time) !!} ,
            curModel:             [],
            curDealerAccount:     '',
            curFreebies:          [],
            curDeliveryDetails:   [],
            active_tab:           0,
            fpc_attachment:       [],
            fpc_attachment_label: 'Choose file',
            remarks:              '',
            action:               '',
            cur_lead_time_desc:   '',
            cur_variant:          '',
            cur_fpc_project_id:   '',
            status_colors:        {!! json_encode($status_colors) !!},
            pricelist_headers:        {!! json_encode($pricelist_headers) !!},
            selected_pricelist : '',
            cur_pricelist_line_id : '',
            curModelIndex : '',
            curProjectIndex : ''
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
                });
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
                var action = self.action;
                var errors = [];
                for(var prj of self.projects){
                    if(prj.payment_terms == "" || prj.payment_terms == null){
                        errors.push("Select a payment term for " + prj.dealer_account + ".");
                    }

                    if(prj.validity == "" || prj.payment_terms == null){
                        errors.push("Select validity date for " + prj.dealer_account + ".");
                    }

                    if(prj.availability == "" || prj.availability == null){
                        errors.push('Please enter availability for ' + prj.dealer_account);
                    }

                    if(prj.note == "" || prj.note == null){
                        errors.push('Please enter note for ' + prj.dealer_account);
                    }
                }

                if(errors.length > 0){
                    var message = "<ul>";
                    for(var msg of errors){
                        message += "<li>" + msg + "</li>";
                    }
                    message += "<ul>";
                    Swal.fire({
                        type: 'error',
                        title: message,
                        showConfirmButton: true
                    });
                    $("#fpcApprovalModal").modal('hide');
                    return false;
                }

                data.append('fpc_id',self.fpc_details.fpc_id);
                data.append('remarks',self.remarks);
                data.append('fpc_project_id',self.cur_fpc_project_id);
                data.append('action',self.action);

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
                    if(action == "approve"){
                        self.toast('success','FPC has been approved!');
                        $("#fpcApprovalModal").modal('hide');
                        self.fpc_details.status_name = response.data.status;
                        self.editable = response.data.editable; 
                    }
                    else {
                        self.toast('success','File successfully uploaded!');
                        $("#fpcApprovalModal").modal('hide');
                    }
                });

            },
            saveTerms(index){
                var self = this;
                var project = self.projects[index];
                var errors = [];

                if(project.payment_terms == "" || project.payment_terms == null){
                    errors.push('Select payment term for ' + project.dealer_account);
                }

                if(project.validity == "" || project.validity == null){
                    errors.push('Select validity for ' + project.dealer_account);
                }

                if(project.availability == "" || project.availability == null){
                    errors.push('Please enter availability for ' + project.dealer_account);
                }

                if(project.note == "" || project.note == null){
                    errors.push('Please enter note for ' + project.dealer_account);
                }


                if(errors.length > 0){
                    var message = "<ul>";
                    for(msg of errors){
                        message += "<li>" + msg + "</li>";
                    }
                    message += "</ul>";
                    Swal.fire({
                        type: 'error',
                        title: message,
                        showConfirmButton: true
                    });
                    return false;
                }

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
                })
                .then((response) => {
                    KTApp.unblockPage();
                    self.toast('success','Saved data.'); 
                })
                .catch( (error) => {
                    KTApp.unblockPage();
                    self.toast('error','Unexpected error ocurred, please try again.');
                    console.log(error);
                })
                .finally( (response) => {
                    KTApp.unblockPage();
                });
            },  
            priceConfirmation(order,dealerAccount,projectIndex,requirementIndex){
                var self = this;
                self.curDealerAccount = dealerAccount;
                self.curModelIndex = requirementIndex;
                self.curProjectIndex = projectIndex;
                self.selected_pricelist = order.pricelist_header_id;
                self.cur_pricelist_line_id = order.pricelist_line_id;
                self.curModel = order;
                console.log(self.curModel.lto_registration);
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
                        amount : 0,
                        cost_to : 6     
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
                    modelData          : self.curModel,
                    freebies           : self.curFreebies,
                    pricelist_header_id: self.selected_pricelist,
                    pricelist_line_id  : self.cur_pricelist_line_id
                })
                .then((response) => {
                    self.projects[self.curProjectIndex].requirements[self.curModelIndex].pricelist_header_id = self.selected_pricelist;
                    self.projects[self.curProjectIndex].requirements[self.curModelIndex].pricelist_line_id = self.cur_pricelist_line_id;
                    self.toast('success','Saved data.');
                })
                .catch( (error) => {
                    self.toast('error',error);
                })
                .finally( () => {
                    $("#priceConfirmationModal").modal('hide');
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
                let vehicle_lead_time = this.vehicle_lead_time[order.model_variant];  
                this.cur_lead_time_desc = vehicle_lead_time == 1 ? vehicle_lead_time + " month" : vehicle_lead_time + " months";        
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
            },
            saveDeliveryDate(){
                var self = this;

                var total = self.curDeliveryDetails.reduce((acc,item) => parseFloat(acc) + parseFloat( item.owner_id == 5 ? item.quantity : 0),0);
                if(total == self.curModel.quantity){
                    axios.post('update-suggested-date', {
                        delivery_details : this.curDeliveryDetails
                    }).then( (response) => {
                         self.toast('success','Delivery schedule has been saved.');
                          $("#additionalDetailsModal").modal('hide');
                    });
                }
                else {
                    self.toast('error','Invalid total for suggested delivery schedule.');
                }
            },
            addDeliveryDate(){
                var self = this;

                let vehicle_lead_time = this.vehicle_lead_time[this.curModel.model_variant];
                let min_delivery_date =  moment().add(vehicle_lead_time, 'months').format('YYYY-MM-DD');
                let default_delivery_date = moment().add(vehicle_lead_time, 'months').format('YYYY-MM-DD')
              

                self.curDeliveryDetails.push({
                    delivery_date : default_delivery_date,
                    owner_id : 5,
                    quantity : '',
                    min_delivery_date : min_delivery_date,
                    requirement_line_id : this.curModel.requirement_line_id,
                    delivery_schedule_id : -1
                });
            },
            deleteDeliveryDate(row,index){
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
                        if(row.delivery_schedule_id != -1){
                            axios.delete('delivery-schedule/' + row.delivery_schedule_id)
                                .then( (response) => {
                                    self.curDeliveryDetails.splice(index,1); 
                                });
                        }
                        else {
                            self.curDeliveryDetails.splice(index,1);  
                        }      
                    }
                });  
            },
            showAttachmentModal(index){
                var self = this;
                self.cur_fpc_project_id = self.projects[index].fpc_project_id;
                this.action = "attach";
                $("#fpcApprovalModal").modal('show');
            },
            cancelProject(index){
                var self = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.value) {
                          
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });

                        axios.post('cancel-fpc-project',{
                            project_id:     self.projects[index].project_id,
                            fpc_project_id: self.projects[index].fpc_project_id,
                        }).then( (response) => {
                            self.toast('error','Project has been cancelled.');
                        });
        
                        KTApp.unblockPage();
        
                    }
        
                });
                
            }
        },
        created: function () {
            // `this` points to the vm instance
        },
        mounted : function () {
            $("#sel_payment_term").select2({
                placeholder : 'Choose payment term'
            });
        },
        computed: {
            sumFreebies(){
                return this.curFreebies.reduce((acc,item) => parseFloat(acc) + (item.cost_to == 5 ? parseFloat(item.amount) : 0),0);
            },
            calculateCost(){
                return parseFloat(this.curModel.wholesale_price) + parseFloat(this.calculateMargin) + parseFloat(this.sumFreebies) + parseFloat(this.curModel.lto_registration);
            },
            calculateMargin(){
                //return (parseFloat(this.curModel.fleet_price) - parseFloat(this.sumFreebies)) * parseFloat(this.curModel.dealers_margin/100);
                return parseFloat(this.curModel.fleet_price) * parseFloat(this.curModel.dealers_margin/100);
            },
            calculateNetCost(){
                return parseFloat(this.calculateCost) + parseFloat(this.curModel.promo);
            },
            calculateSubsidy(){
                return (parseFloat(this.calculateNetCost) - parseFloat(this.curModel.fleet_price));
            },
            calculateTotalSubsidy(){
                return (parseFloat(this.calculateSubsidy) * parseFloat(this.curModel.quantity));
            },
            calculateWSP(){
                return parseFloat(this.curModel.suggested_retail_price) - (parseFloat(this.curModel.suggested_retail_price) * (this.curModel.dealers_margin/100));
            },
            calculateSRP(){
                return parseFloat(this.curModel.wholesale_price) + parseFloat(this.calculateMargin) + parseFloat(this.calculateVAT);
            },
            calculateVAT(){
                return parseFloat(this.curModel.wholesale_price * 0.12);
            }
        },
        watch : {
            selected_pricelist : function(val, oldVal){
                var self = this;
                
                if(val == "" || val == null){
                    return false;
                }

                KTApp.block("#priceConfirmationModal .modal-content",{
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                
                
                //if(self.curModel.suggested_retail_price == 0){
                    axios.get('get-vehicle-price',{
                        params : {
                            pricelist_header_id : val,
                            inventory_item_id : self.curModel.inventory_item_id
                        }
                    })
                    .then( (response) => {  
                        if(response.data.status == 404){
                            self.toast('error','Price not found!');
                            return false;
                        }

                        self.curModel.suggested_retail_price = response.data.price.srp;
                        self.curModel.wholesale_price        = response.data.price.wsp;
                        if(self.curModel.lto_registration <= 0){
                            self.curModel.lto_registration       = response.data.price.lto_registration;
                        }
                        if(oldVal != ""){
                            self.curModel.lto_registration       = response.data.price.lto_registration;
                        }
                        self.curModel.promo                  = response.data.price.promo;
                        self.cur_pricelist_line_id           = response.data.price.pricelist_line_id;
                        
                    })
                    .catch( (error) => {
                        self.toast('error',error);
                    })
                    .finally( () => {
                        KTApp.unblock("#priceConfirmationModal .modal-content",{});
                    });
                }
            //}
        }
    });
</script>
@endpush