@extends('_layouts.metronic')

@section('page-title', 'Purchase Order Overview')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--mobile" >
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Details
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            @if($action == "validate")
            <a href="#"class="btn btn-success btn-sm kt-margin-r-5"  @click="validatePO('approve')">
                <span class="kt-hidden-mobile">Approve</span>
            </a>
            <a href="#"class="btn btn-danger btn-sm" @click="validatePO('reject')">
                <span class="kt-hidden-mobile">Reject</span>
            </a>
            @endif
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-6">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Ref No.</span>
                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ po_details.po_header_id }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">PO Number</span>
                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ po_details.po_number }}</span>
                </div> 
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Fleet Account Name</span>
                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ po_details.account_name }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Date Submitted</span>
                    <span class="col-md-8">@{{ po_details.date_created }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                    <span class="col-md-8">@{{ po_details.created_by }}</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Status</span>
                    <span class="col-md-8">
                        <span :class="status_colors[po_details.status_name]">@{{ po_details.status_name }}</span>
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Attachment</span>
                    <span class="col-md-8">
                        <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                            <li v-for="(row,index) in attachments">
                                <a :href="base_url + '/' + row.symlink_dir + row.filename" download>@{{ row.orig_filename }}</a>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Items 
            </h3>
        </div>
      
    </div>
    <div class="kt-portlet__body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-light-gray-2">
                        <th>Model</th>
                        <th>Color</th>
                        <th>Unit Price</th>
                        <th>Order Qty</th>
                        <th>Total Price</th>
                        <th>PO Qty</th>
                        <th>Delivery Sched</th>
                    </tr>
                </thead>
                <tbody v-for="(value,key) in po_lines">
                    <tr v-for="(item,index) in po_lines[key]">
                        <td> @{{ item.sales_model }} </td>
                        <td> <span :class="vehicle_colors[item.color]">&nbsp</span> @{{ item.color }} </td>
                        <td align="right"> @{{ item.fleet_price | formatPeso }} </td>
                        <td align="right"> @{{ item.quantity }} </td>
                        <td align="right"> @{{ ( parseFloat(item.quantity) * parseFloat(item.fleet_price) ) | formatPeso }} </td>
                        <td align="right">@{{ item.po_quantity }}</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm btn-icon btn-circle" @click.prevent="setDeliverySched(key,index)">
                                <i class="la la-calendar"></i>
                            </a> 
                        </td>
                    </tr>
                    <tr  class="bg-light-gray-1 kt-font-bold">
                        <td colspan="3">@{{ key }}</td>
                        <td align="right">@{{ sumQty(key) }}</td>
                        <td align="right">@{{ calculateSubtotal(key) | formatPeso}}</td>
                        <td align="right">@{{ sumPOQty(key) }}</td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-light-gray-2 kt-font-boldest">
                        <td colspan="3">Grand Total</td>
                        <td align="right">@{{ totalQty }}</td>
                        <td align="right">@{{ totalPrice | formatPeso}}</td>
                        <td align="right">@{{ totalPO }}</td> 
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<!--begin::Modal-->
 <div class="modal fade" id="deliverySchedModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">   
                <div class="row kt-margin-b-10">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Order Details</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="details-item col-md-4">
                                        <span class="details-label">Model</span>
                                        <span class="details-subtext">@{{ curModel }}</span>
                                    </div>
                                    <div class="details-item col-md-4">
                                        <span class="details-label">Color</span>
                                        <span class="details-subtext">@{{ curColor }}</span>
                                    </div>
                                    <div class="details-item col-md-4">
                                        <span class="details-label">Quantity</span>
                                        <span class="details-subtext">@{{ curQuantity }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">Requested Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched" v-if="row.owner_id == 6">
                                            <td>@{{ row.delivery_date_disp }}</td>
                                            <td>@{{ row.quantity }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                            <td>Total</td>
                                            <td >@{{ totalDeliveryQty(6) }}</td>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Recommended Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table" v-if="action == 'view'">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched" v-if="row.owner_id == 5">
                                            <td>@{{ row.delivery_date_disp }}</td>
                                            <td>@{{ row.quantity }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                            <td>Total</td>
                                            <td >@{{ totalDeliveryQty(5) }}</td>
                                        </tr>
                                    </tfoot>
                                </table> 

                                <table class="table" v-if="action == 'validate'">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
                                        <tr v-for="(row,index) in curDeliverySched" v-if="row.owner_id == 5 && row.delete_flag == 'N'">
                                            <td><a href="#" @click.prevent="deleteRowSched(index)"><i class="fa fa-trash kt-font-danger"></i></a></td>
                                            <td><input type="date" class="form-control form-control-sm" v-model="row.delivery_date" /></td>
                                            <td><input type="text" size="3" class="form-control form-control-sm" v-model="row.quantity" /></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                            <td colspan="2">Total</td>
                                            <td>@{{ totalDeliveryQty(5) }}</td>
                                        </tr>
                                    </tfoot>
                                </table> 

                            </div> 
                            <div class="card-footer" v-if="action == 'validate'">>
                                <button type="button" @click="addRowSched" class="btn btn-primary btn-sm">Add</button>
                                <button type="button" @click="saveDeliverySched" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div> 
                    </div>
                </div>      
            </div>
          
          
        </div>
    </div>
</div> 
<!--end::Modal-->


<!--begin::Modal-->
<div class="modal fade" id="validateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@{{ vm_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">          
                <div class="form-group">
                    <label>@{{ vm_message }}</label>
                    <textarea class="form-control" v-model="remarks"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="confirmValidate" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
            po_details:       {!! json_encode($po_details) !!},
            po_lines:         {!! json_encode($po_lines) !!},
            vehicle_colors:   {!! json_encode($vehicle_colors) !!},
            status_colors:    {!! json_encode($status_colors) !!},
            attachments:      {!! json_encode($attachments) !!},
            base_url:         {!! json_encode($base_url) !!},
            curDeliverySched: [],
            curVehicleType:   '',
            curLineIndex:     '',
            curModel:         '',
            curColor:         '',
            curQuantity:      '',
            curVariant:       '',
            validate_status:  '',
            vm_title:         '',
            vm_message:       '',
            remarks:          '',
            po_header_id:     {!! json_encode($po_header_id) !!},
            approval_id:      {!! json_encode($approval_id) !!},
            action:           {!! json_encode($action) !!},
        },
        created: function () {
            this.po_lines = _.groupBy(this.po_lines, 'vehicle_type');
        },
        methods : {
            setDeliverySched(vehicle_type,line_index){
                this.curDeliverySched = this.po_lines[vehicle_type][line_index].delivery_sched;
                this.curModel         = this.po_lines[vehicle_type][line_index].sales_model;
                this.curColor         = this.po_lines[vehicle_type][line_index].color;
                this.curQuantity      = this.po_lines[vehicle_type][line_index].quantity;
                this.curVehicleType   = vehicle_type;
                this.curLineIndex     = line_index;
                this.curVariant       = this.po_lines[vehicle_type][line_index].variant;
                $("#deliverySchedModal").modal('show');
            },
            deleteRowSched(index){
                if(this.curDeliverySched[index].hasOwnProperty('delivery_schedule_id')){
                    this.curDeliverySched[index].delete_flag = 'Y';
                }
                else {
                    this.curDeliverySched.splice(index,1);
                }
            },
            sumQty(vehicle_type){
               return this.po_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            sumPOQty(vehicle_type){
               return this.po_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.po_quantity),0);
            },
            calculateSubtotal(vehicle_type){
                return this.po_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + (parseFloat(item.quantity) * parseFloat(item.fleet_price)),0);
            },
            validatePO(status){
                var self = this;
                self.validate_status = status;
                if(status == "approve"){
                    self.vm_title = 'Approve PO';
                    self.vm_message = 'Are you sure you want to Approve the PO?';
                }
                else if (status == "reject"){
                    self.vm_title = 'Reject PO';
                    self.vm_message = 'Are you sure you want to Reject the PO?';
                }
                $("#validateModal").modal('show')
            },
            confirmValidate(){
                var self = this;
                KTApp.block("#validateModal .modal-content",{});
                axios.post('/save-po-validation', {
                    status:       self.validate_status,
                    po_header_id: self.po_header_id,
                    approval_id:  self.approval_id,
                    remarks:      self.remarks,
                    project_id:   self.po_details.project_id
                })
                .then(function (response) {
                    window.location.href = self.base_url +  "/all-po";
                })
                .catch(function (error) {
                    Swal.fire({
                        type: 'error',
                        title: 'System encountered unexpected error.' + error,
                        showConfirmButton: true
                    });
                    KTApp.unblockPage();
                }).finally( (response) => {
            
                });
            },
            totalDeliveryQty(owner_id){
                return this.curDeliverySched.reduce((acc,item) => parseFloat(acc) + (item.owner_id == owner_id ? parseFloat(item.quantity) : 0 ),0);
            },
            addRowSched(){
                this.curDeliverySched.push({
                    delivery_date : '',
                    quantity : 0,
                    owner_id : 5,
                    delete_flag : 'N'
                });
            },
            saveDeliverySched(){
                var self = this;
                 
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.post('/save-po-schedule', {
                    delivery_details:    self.curDeliverySched,
                    po_line_id:          self.po_lines[self.curVehicleType][self.curLineIndex].po_line_id,
                    requirement_line_id: self.po_lines[self.curVehicleType][self.curLineIndex].requirement_line_id,
                })
                .then(function (response) {
                    self.po_lines[self.curVehicleType][self.curLineIndex].delivery_sched = response.data;
             
                    Swal.fire({
                        type: 'success',
                        title: 'Recommended delivery schedule has been updated!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    KTApp.unblockPage();
                })
                .catch(function (error) {
                    Swal.fire({
                        type: 'error',
                        title: 'System encountered unexpected error.' + error,
                        showConfirmButton: true
                    });
                    KTApp.unblockPage();
                }).finally( (response) => {
            
                });


                $("#deliverySchedModal").modal('hide');
            },
        },
        computed : {
            totalQty(){
                var total_qty = 0;
                var self = this;
                for(vehicle_type in this.po_lines){
                    total_qty += self.sumQty(vehicle_type);
                }
                return total_qty;
            },
            totalPrice(){
                var self = this;
                var total_price = 0;
                for(vehicle_type in self.po_lines){
                    total_price += self.calculateSubtotal(vehicle_type);
                }
                return total_price;
            },
            totalPO(){
                var self = this;
                var total_po = 0;
                for(vehicle_type in self.po_lines){
                    total_po += self.sumPOQty(vehicle_type);
                }
                return total_po;
            }
        },
        mounted : function () {
            
        },
        filters: {
            formatPeso: function (value) {
                 return `${parseFloat(value).toLocaleString()}`
            }
        }
    });


   
</script>
@endpush