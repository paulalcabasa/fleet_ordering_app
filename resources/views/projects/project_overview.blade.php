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
                    <a class="nav-link" data-toggle="tab" href="#timeline" role="tab" aria-selected="false">
                        Timeline
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="account">
                @include('projects.subform.account')
            </div>
            <div class="tab-pane" id="contact">
                @include('projects.subform.contact')
            </div>
            <div class="tab-pane" id="requirement">
                @include('projects.subform.requirement')
            </div>
            <div class="tab-pane" id="competitors">
                @include('projects.subform.competitors')
            </div>
            <div class="tab-pane" id="timeline">
                @include('projects.subform.timeline')
            </div>
        </div>
    </div>

    <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                @if($action == "validate")
                <button type="submit" class="btn btn-success btn-sm" @click="validateProject('approve')">Approve</button>
                <button type="submit" class="btn btn-danger btn-sm"  @click="validateProject('reject')">Reject</button>
                <a :href="base_url + '/manage-project/edit/' + projectDetails.project_id" class="btn btn-primary btn-sm" v-if="projectDetails.status_name == 'New' && user_type == 31">Edit</a>
                @elseif($action == "view")
                <a :href="base_url + '/manage-project/edit/' + projectDetails.project_id" class="btn btn-primary btn-sm" v-if="projectDetails.status_name == 'New'">Edit</a>
                <button type="button" class="btn btn-danger btn-sm" @click="cancelProject()" v-if="projectDetails.status_name != 'Cancelled'">Cancel</button>
                <button type="button" class="btn btn-success btn-sm" @click="closeProject()" v-if="projectDetails.status_name == 'Open'">Close</button>
                <button type="button" class="btn btn-success btn-sm" @click="reopenProject()" v-if="projectDetails.status_name == 'Closed'">Re-open</button>
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

</div> 
<!-- end of app wrapper -->
@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            approvalId:               {!! json_encode($approval_id) !!},
            projectId:                {!! json_encode($project_id) !!},
            projectDetails:           {!! json_encode($project_details) !!},
            customerDetails:          {!! json_encode($customer_details) !!},
            attachments:              {!! json_encode($attachments) !!},
            affiliates:               {!! json_encode($affiliates) !!},
            contacts:                 {!! json_encode($contacts) !!},
            contactPersons:           {!! json_encode($contact_persons) !!},
            salesPersons:             {!! json_encode($sales_persons) !!},
            requirement:              {!! json_encode($requirement) !!},
            competitors:              {!! json_encode($competitors) !!},
            base_url:                 {!! json_encode($base_url) !!},
            competitor_attachments:   {!! json_encode($competitor_attachments) !!},
            status_colors:            {!! json_encode($status_colors) !!},
            vehicle_colors:           {!! json_encode($vehicle_colors) !!},
            vehicle_user_type:        {!! json_encode($vehicle_user_type) !!},
            add_po_flag:              {!! json_encode($add_po_flag) !!},
            pending_fpc_vehicle_type: {!! json_encode($pending_fpc_vehicle_type) !!},
            cancel_flag:              false,
            remarks:                  null,
            curBodyBuilder:           null,
            curRearBody:              null,
            curAdditionalItems:       null,
            curModel:                 "",
            curColor:                 "",
            curQuantity:              "",
            curDeliveryDetails:       [],
            curFreebies:              [],
            curDeliverySched:         [],
            fpc:                      {!! json_encode($fpc) !!},
            po_list:                  {!! json_encode($po_list) !!},
            cur_sales_order_number:   '',
            cur_so_details:           [],
            cur_so_header:            [],
            cur_so_lines:             [],
            fwpc:                     {!! json_encode($fwpc) !!},
            user_type:                {!! json_encode($user_type) !!},
            display_alert:            false,
            cur_fpc_project_id:       '',
            selected_fpc:             "",
            selected_po : "",
            cur_fpc_details:          {
                date_created : '',
                prepared_by : '',
                validity : '',
                status_name : '',
                fpc_project_id : '',
                vehicle_type : ''
            },
            cur_po_details : {
                date_created : '',
                prepared_by : '',
                po_header_id : '',
                status_name : ''
            },
            signed_fwpc : '',
            cur_fwpc_id : ''
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
            validateProject(status){
                var self = this;

                Swal.fire({
                    title: "Confirmation",
                    text: "Are you sure to " + status + " the project?",
                    input: 'textarea',
                    inputPlaceholder : "Please write your remarks...",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'        
                }).then((result) => {
                    if(result.dismiss != "cancel"){
                   // if(result.value){
                        axios.post('/save-approval', {
                            approvalId : self.approvalId,
                            projectId : self.projectId,
                            remarks : result.value,
                            status : status
                        })
                        .then(function (response) {
                            var swal_type;
                            var swal_title;

                            if(status == "approve"){
                                swal_type = "success";
                                swal_title = "Project has been approved!";
                            }
                            else if(status == "reject"){
                                swal_type = "error";
                                swal_title = "Project has been rejected!";
                            }
                           /* else if(status == "revise"){
                                swal_type = "error";
                                swal_title = "Project will be revised!";
                            }*/

                            Swal.fire({
                                type: swal_type,
                                title: swal_title,
                                showConfirmButton: false,
                                timer: 1500,
                                onClose : function(){
                                    window.location.href = self.base_url + "/project-overview/view/"+ self.projectId;
                                }
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            closeProject(){
                var self = this;
                Swal.fire({
                    title: 'Are you sure you want to close the project?',
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
            reopenProject(){
                var self = this;
                Swal.fire({
                    title: 'Are you sure you want to re-open the project?',
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
                    
                        axios.post('/ajax-reopen-project', {
                            project_id : self.projectDetails.project_id
                        })
                        .then(function (response) {
                            var data = response.data;
                            self.projectDetails.status_name = data.status;
                            KTApp.unblockPage();
                            Swal.fire({
                                type: 'success',
                                title: 'Project has been re-opened!',
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
                        elem.fpc_project_id === self.cur_fpc_details.fpc_project_id
                    ) {
                        return elem.order_number;
                    }
                });
                if(isExist == 0 ){
                    KTApp.block("#addFWPC .modal-content",{});
                    axios.post('/sales-order', {
                        project_id:     self.projectDetails.project_id,
                        sales_order_id: self.cur_so_details.header_id,
                        so_number:      self.cur_so_details.order_number,
                        fpc_project_id: self.cur_fpc_details.fpc_project_id,
                        po_header_id:   self.cur_po_details.po_header_id

                    }).then( (response) => {
                        KTApp.unblock("#addFWPC .modal-content",{});
                        $("#addFWPC").modal('hide');
                        self.fwpc.push(response.data);
                        self.cur_so_details = [];
                        self.cur_sales_order_number = '';
                        window.reload();
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
                        
                        axios.post('delete-fwpc',{
                            fwpc_id : self.fwpc[index].fwpc_id
                        })
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
            triggerFileUpload(index){
                $("#signed_fwpc").click();
                this.cur_fwpc_id = this.fwpc[index].fwpc_id;
            },
            uploadDocument(){
                var self = this;
                self.signed_fwpc = self.$refs.signed_fwpc.files[0];
                var size_mb = self.signed_fwpc.size / 1024 / 1024;
                if(size_mb >= 10){
                    Swal.fire({
                        type: 'error',
                        title: 'File must be less than 10mb.',
                        timer : 1500,
                        showConfirmButton : false
                    });
                    $("#signed_fwpc").val("");
                    self.signed_fwpc = '';
                } // (size_mb >= 10)
                else {
                    Swal.fire({
                        title: 'Uploading this file will override the previous one you uploaded, click Confirm to continue.',
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
                            
                            let formData = new FormData();

                            formData.append('file', self.signed_fwpc);
                            formData.append('fwpc_id', self.cur_fwpc_id);

                            axios.post('upload-fwpc-doc',
                                formData,{
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            }).then( (response) => {
                                KTApp.unblockPage();
                                Swal.fire({
                                    type: 'success',
                                    title: 'File has been uploaded!',
                                    timer : 1500,
                                    showConfirmButton : false       
                                }).then( (response) => {
                                    window.location.reload(true); 
                                });
                        
                            }).catch(function(){
                                console.log('FAILURE!!');
                            });
                        }
                    });   
                } // else 
            }, // uploadDocument(){
            validateFWPC(index,status){
                // to do on august 22 2019
                var self = this;
                var fwpc_details = self.fwpc[index];
        
                Swal.fire({
                    title: "Confirmation",
                    text: "Are you sure to " + status + " the FWPC?",
                    input: 'textarea',
                    inputPlaceholder : "Please state your reason (optional)",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'        
                }).then((result) => {
                   if(result.dismiss != "cancel"){
                        axios.post('validate-fwpc', {
                            fwpc_id : fwpc_details.fwpc_id,
                            status : status,
                            remarks : result.value
                        })
                        .then(function (response) {
                            var data = response.data;
                            var status_name = "";
                            if(status == 'approve'){
                                swal_type = "success";
                                swal_message = "FWPC has been approved!";
                                status_name = "Approved";
                            }
                            else if(status == 'reject'){
                                swal_type = "error";
                                swal_message = "FWPC has been rejected!"; 
                                status_name = "Rejected";
                            }
                        
                            Swal.fire({
                                type: swal_type,
                                title: swal_message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then( (response) => {
                                self.fwpc[index].status_name = status_name;
                            });
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }  
                });
            },
            showAddFWPC(){
                // defaultly select the fpc
                var self = this;
                for (var i = 0; i < self.fpc.length; i++) {
                    if(self.fpc[i]['fpc_header'].vehicle_type == self.vehicle_user_type){
                        self.selected_fpc = i;
                        break;
                    }  
                }
                $("#addFWPC").modal('show');
            },
            printFPC(project_id,fpc_id){
                //:href="base_url + '/print-fpc-dealer/single/' + projectDetails.project_id + '/' + row['fpc_header'].fpc_id" ";
                if(this.user_type == 32 || this.user_type == 33){
                    window.open(this.base_url + "/print-fpc/" + fpc_id); 
                }
                else {
                    window.open(this.base_url +'/print-fpc-dealer/single/' + project_id + '/' + fpc_id);
                }
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
        },
        watch : {
            selected_fpc : function(val){
                if(this.fpc[val]){
                    this.cur_fpc_details.date_created   = this.fpc[val]['fpc_header'].date_created;
                    this.cur_fpc_details.prepared_by    = this.fpc[val]['fpc_header'].prepared_by;
                    this.cur_fpc_details.validity       = this.fpc[val]['fpc_header'].validity;
                    this.cur_fpc_details.status_name    = this.fpc[val]['fpc_header'].status_name;
                    this.cur_fpc_details.fpc_project_id = this.fpc[val]['fpc_header'].fpc_project_id;
                    this.cur_fpc_details.vehicle_type   = this.fpc[val]['fpc_header'].vehicle_type;
                }
            }, 
            selected_po : function(val){
                if(this.po_list[val]){
                    this.cur_po_details.date_created = this.po_list[val].date_created;
                    this.cur_po_details.prepared_by  = this.po_list[val].created_by;
                    this.cur_po_details.po_header_id = this.po_list[val].po_header_id;
                    this.cur_po_details.status_name  = this.po_list[val].status_name;
                }
            }
        }
        
    });
</script>
@endpush