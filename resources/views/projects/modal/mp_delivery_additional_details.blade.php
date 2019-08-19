
<div class="modal fade" id="deliveryScheduleModal" data-backdrop="static" data-keyboard="false"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery and Other Details</h5>
             <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Other details
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name of Body Builder</label>
                                    <input type="text" class="form-control form-control-sm" v-model="cur_body_builder" placeholder="Body builder" />
                                   <!--  <span class="form-text text-muted">Please a body builder</span> -->
                                </div>
                                <div class="form-group">
                                    <label>Rear Body Type</label>
                                    <input type="text" class="form-control form-control-sm" v-model="cur_rear_body" name="fname" placeholder="Rear Body Type" >
                                    <!-- <span class="form-text text-muted">Please enter rear body type</span> -->
                                </div>  
                                <div class="form-group">
                                    <label>Additional Items</label>
                                    <textarea class="form-control form-control-sm" v-model="cur_addtl_items"></textarea>
                                 <!--    <span class="form-text text-muted">Please enter additional items</span> -->
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Delivery details</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">

                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">
                                                @{{ cur_model }}
                                                <span 
                                                    data-toggle="kt-popover" 
                                                    title="" 
                                                    :data-content="cur_lead_time_desc" 
                                                    data-original-title="Delivery lead time">
                                                    <i class="fa fa-info-circle kt-font-primary"></i>    
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="details-item">
                                            <span class="details-label">Color</span>
                                            <span class="details-subtext">@{{ cur_color }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">@{{ cur_quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in cur_delivery_sched" :key="index">
                                            <td>
                                                <a href="#" @click.prevent="deleteDeliveryDate(index)">
                                                    <i class="flaticon flaticon-delete kt-margin-r-10 kt-font-danger"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" size="4" v-model="row.quantity" />
                                            </td>
                                            <td>
                                                <input type="date" :min="row.min_delivery_date" class="form-control form-control-sm" v-model="row.delivery_date" name="">
                                            </td>

                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th colspan="2">@{{ computeDeliveryQuantity }}</th>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                        </div>
                                           
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="saveDeliverySched">Save</button>
                <button type="button" class="btn btn-primary" @click="addDeliverySched">Add row</button>
            </div>
        </div>
    </div>
</div>
