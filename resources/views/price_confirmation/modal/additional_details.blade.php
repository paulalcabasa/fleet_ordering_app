<!--begin::Modal-->
<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Additional items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="card kt-margin-b-10">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="details-item">
                                    <span class="details-label">Sales Model</span>
                                    <span class="details-subtext">
                                        @{{  curModel.sales_model  }}
                                         <span 
                                            data-toggle="kt-popover" 
                                            title="" 
                                            :data-content="cur_lead_time_desc" 
                                            data-original-title="Delivery lead time">
                                            <i class="fa fa-info-circle kt-font-primary"></i>    
                                        </span>
                                    </span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Color</span>
                                    <span class="details-subtext">@{{ curModel.color }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Quantity</span>
                                    <span class="details-subtext">@{{ curModel.quantity }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Delivery Schedule</div>
                            <div class="card-body">
                                <!-- <div class="table-responsive"> -->
                                     <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Quantity</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in curDeliveryDetails" v-if="row.owner_id == 6">
                                                <td>@{{ row.delivery_date_disp }}</td>
                                                <td>@{{ row.quantity }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div>  -->
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Suggested Delivery Schedule</div>
                            <div class="card-body">
                                <!-- <div class="table-responsive"> -->
                                     <table class="table table-condensed" v-if="fpc_details.status_name == 'In progress'">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <td>Date</td>
                                                <td>Quantity</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in curDeliveryDetails" v-if="row.owner_id == 5">
                                                <td>
                                                    <a href="#" @click.prevent="deleteDeliveryDate(row,index)">
                                                        <i class="flaticon flaticon-delete kt-margin-r-10 kt-font-danger"></i>
                                                    </a>
                                                </td>
                                                <td><input type="date" class="form-control form-control-sm" name="" :min="row.min_delivery_date" v-model="row.delivery_date" /></td>
                                                <td><input type="text" size="3" class="form-control form-control-sm" name="" v-model="row.quantity" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-condensed" v-if="fpc_details.status_name != 'In progress'">
                                        <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Quantity</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,index) in curDeliveryDetails" v-if="row.owner_id == 5">
                                                <td>@{{ row.delivery_date_disp }}</td>
                                                <td>@{{ row.quantity }}</td>
                                               
                                            </tr>
                                        </tbody>
                                    </table>
                                <!-- </div>  -->
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="addDeliveryDate" v-if="fpc_details.status_name == 'In progress'">Add</button>
                <button type="button" class="btn btn-success" @click="saveDeliveryDate" v-if="fpc_details.status_name == 'In progress'">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->