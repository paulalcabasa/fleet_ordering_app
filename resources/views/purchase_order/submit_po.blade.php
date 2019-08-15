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

<div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                
            </h3>
        </div>
      
    </div>
    <div class="kt-portlet__body">
        <div class="form-group row">
            <div class="col-md-6">
                <label>PO Number</label>
                <input type="text" v-model.lazy="poNumber" class="form-control"/>
            </div>
            <div class="col-md-6">
                <label>PO Document</label>
                <div></div>
                <div class="custom-file">
                    <input type="file" @change="validateFileSize()" class="custom-file-input" ref="customFile" name="attachments[]" id="attachments" multiple="true">
                    <label class="custom-file-label" for="attachment">@{{ file_label }}</label>
                    <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                        <li v-for="(row,index) in attachments">
                            <span v-if="row.directory == null">@{{ row.orig_filename }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
            <tbody v-for="(value,key) in requirement_lines">
                <tr v-for="(item,index) in requirement_lines[key]">
                    <td> @{{ item.sales_model }} </td>
                    <td> <span :class="vehicle_colors[item.color]">&nbsp</span> @{{ item.color }} </td>
                    <td align="right"> @{{ item.fleet_price | formatPeso }} </td>
                    <td align="right"> @{{ item.quantity }} </td>
                    <td align="right"> @{{ ( parseFloat(item.quantity) * parseFloat(item.fleet_price) ) | formatPeso }} </td>
                    <td>
                        <input type="text" v-model="item.po_qty" class="form-control form-control-sm kt-align-right" size="4"/>
                    </td>
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
    <div class="kt-portlet__foot">
        <div class="row">
            <div class="col-lg-12 kt-align-right">
                <button type="submit" class="btn btn-brand" @click="submitPO()">Submit</button>
            </div>
        </div>
    </div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="deliverySchedModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <div class="card-header">Order Details</div>
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
                                    <span class="details-subtext">@{{ curQuantity }}</span>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Delivery Details</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched">
                                            <td><a href="#" @click.prevent="deleteRowSched(index)"><i class="fa fa-trash kt-font-danger"></i></a></td>
                                            <td><input type="date" class="form-control form-control-sm" v-model="row.delivery_date" /></td>
                                            <td><input type="text" class="form-control form-control-sm" v-model="row.quantity" /></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                            <td></td>
                                            <td>Total</td>
                                            <td>@{{ totalDeliveryQty }}</td>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                        </div> 
                    </div>
                </div>      
            </div>
            <div class="modal-footer">
                <button type="button" @click="addRowSched" class="btn btn-primary">Add</button>
                <button type="button" @click="saveDeliverySched" class="btn btn-primary">Save</button>
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
            projectDetails:       {!! json_encode($project_details) !!},
            requirement_lines:    {!! json_encode($requirement_lines) !!},
            vehicle_colors:       {!! json_encode($vehicle_colors) !!},
            status_colors:        {!! json_encode($status_colors) !!},
            base_url:             {!! json_encode($base_url) !!},
            poNumber:             '',
            curDeliverySched:     [],
            curVehicleType:       '',
            curLineIndex:         '',
            curModel:             '',
            curColor:             '',
            curQuantity:          '',
            attachments:          [],
            curRequirementLineId: '',
            file_label:           'Choose file'
        },
        created: function () {
            this.requirement_lines = _.groupBy(this.requirement_lines, 'vehicle_type');
        },
        methods : {
            deleteRowSched(index){
                this.curDeliverySched.splice(index,1);
            },
            addRowSched(){
                this.curDeliverySched.push({
                    delivery_date : '',
                    quantity : 0
                });
            },
            setDeliverySched(vehicle_type,line_index){
                this.curDeliverySched = this.requirement_lines[vehicle_type][line_index].delivery_sched;
                this.curModel = this.requirement_lines[vehicle_type][line_index].sales_model;
                this.curColor = this.requirement_lines[vehicle_type][line_index].color;
                this.curQuantity = this.requirement_lines[vehicle_type][line_index].quantity;
                this.curVehicleType = vehicle_type;
                this.curLineIndex = line_index;
                $("#deliverySchedModal").modal('show');
            },
            saveDeliverySched(){
                var self = this;
                self.requirement_lines[self.curVehicleType][self.curLineIndex].delivery_sched = self.curDeliverySched;
                $("#deliverySchedModal").modal('hide');
            },
            submitPO(){
                var self = this;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                    if (result.value) {
                      
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                    
                        axios.post('/save-po', {
                            requirement_lines: self.requirement_lines,
                            po_number:         self.poNumber,
                            project_id:        self.projectDetails.project_id
                        })
                        .then(function (response) {
                            self.processFileUpload(
                                response.data.po_header_id
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });
            },
            processFileUpload(po_header_id){
                let data = new FormData();
                var self = this;
                data.append('po_header_id',po_header_id);

                $.each($("#attachments")[0].files, function(i, file) {
                    data.append('attachments[]', file);
                });
                
                let settings = { headers: { 'content-type': 'multipart/form-data' } };

                axios.post('/upload-po-attachment', data ,settings).then(function (response) {
                    KTApp.unblockPage();

                    if(response.data.status == "success"){
                        Swal.fire({
                            type: 'success',
                            title: 'PO has been submitted!',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose : function(){
                                var link = self.base_url + '/project-overview/view/' + self.projectDetails.project_id;
                                window.location.href = link;
                            }
                        });
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Unexpected error encountered during the transaction, please contact the system administrator.',
                            showConfirmButton: true
                        });
                    }
                });
            },
            sumQty(vehicle_type){
               return this.requirement_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            sumPOQty(vehicle_type){
               return this.requirement_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + parseFloat(item.po_qty),0);
            },
            calculateSubtotal(vehicle_type){
                return this.requirement_lines[vehicle_type].reduce((acc,item) => parseFloat(acc) + (parseFloat(item.quantity) * parseFloat(item.fleet_price)),0);
            },
            validateFileSize(){
                var self = this;
                var total_size = 0;
                var total_files = 0;
                
                self.attachments = [];

                $.each($("#attachments")[0].files, function(i, file) {
                    total_size += file.size;  
                    self.attachments.push({
                        directory : null,
                        filename : file.name,
                        orig_filename : file.name
                    });
                    total_files++;
                });

                var total_size_mb = total_size / 1024 / 1024;
                if(total_size_mb >= 10){
                    Swal.fire({
                        type: 'error',
                        title: 'Attachment must be less than 10mb.',
                        showConfirmButton: true
                    });

                    $("#attachment").val("");
                    self.attachments = [];
 
                }
                else {
                    self.file_label = total_files + " file" + (total_files > 1 ? "s" : "") + " selected" ;
                }
            },
        },
        computed : {
            totalQty(){
                var total_qty = 0;
                var self = this;
                for(vehicle_type in this.requirement_lines){
                    total_qty += self.sumQty(vehicle_type);
                }
                return total_qty;
            },
            totalPrice(){
                var self = this;
                var total_price = 0;
                for(vehicle_type in self.requirement_lines){
                    total_price += self.calculateSubtotal(vehicle_type);
                }
                return total_price;
            },
            totalPO(){
                var self = this;
                var total_po = 0;
                for(vehicle_type in self.requirement_lines){
                    total_po += self.sumPOQty(vehicle_type);
                }
                return total_po;
            },
            totalDeliveryQty(){
                return this.curDeliverySched.reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
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