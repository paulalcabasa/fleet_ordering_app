<div class="modal fade" id="addFWPC" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add FWPC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">   
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" v-model="cur_sales_order_number" class="form-control" placeholder="Search for sales order number...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" @click="searchSalesOrder">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger kt-margin-t-10" role="alert" v-show="cur_so_details.length == 0 && display_alert">
                            <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                            <div class="alert-text">
                                <strong>@{{ cur_sales_order_number }}</strong> does not exist. <br/>
                                <span>Note : </span>
                                <ul>
                                    <li>The sales order must be of Fleet Order Type.</li>
                                    <li>
                                        @{{ projectDetails.dealer_name }} - @{{ projectDetails.dealer_account}}
                                         must be the customer.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card kt-margin-t-10" v-show="cur_so_details.hasOwnProperty('order_number')">
                            <div class="card-header kt-font-bold">Sales Order Details</div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Sales Order No.</span>
                                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ cur_so_details.order_number }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Customer Name</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.party_name }}
                                        <span class="kt-badge kt-badge--inline kt-badge--success">@{{ cur_so_details.account_name }}</span>
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Customer Type</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.profile_class }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Ordered Date</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.ordered_date }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Order Type</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.order_type_name }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Price List</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.price_list_name }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Payment Term</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.payment_term }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Status</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_details.flow_status_code }}
                                    </span> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card kt-margin-b-10">
                            <div class="card-header kt-font-bold">Fleet Price Confirmation</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <select class="form-control form-control-sm" v-model="selected_fpc">
                                        <option value="">Select fpc</option>
                                        <option 
                                            v-for="(row,index) in fpc"
                                            v-if="row['fpc_header'].vehicle_type == vehicle_user_type"
                                            :value="index" 
                                        >
                                            @{{ row['fpc_header'].fpc_project_id }}
                                        </option>
                                    </select>
                                    <div v-if="cur_fpc_details.date_created != ''" class="kt-margin-t-10">
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Date Created</span>
                                            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ cur_fpc_details.date_created }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Prepared By</span>
                                            <span class="col-md-8">@{{ cur_fpc_details.prepared_by }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Validity</span>
                                            <span class="col-md-8">@{{ cur_fpc_details.validity }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Status</span>
                                            <span class="col-md-8">
                                                <span :class="status_colors[cur_fpc_details.status_name]">@{{ cur_fpc_details.status_name }}</span>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header kt-font-bold">Purchase Order</div>
                            <div class="card-body">
                                <div class="form-group">
                                     <select class="form-control form-control-sm" v-model="selected_po">
                                        <option value="">Select purchase order</option>
                                        <option :value="index" v-for="(row,index) in po_list">
                                            @{{ row.po_number }}
                                        </option>
                                    </select>
                                    <div v-if="cur_po_details.date_created != ''" class="kt-margin-t-10">
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Date Created</span>
                                            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ cur_po_details.date_created }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Prepared By</span>
                                            <span class="col-md-8">@{{ cur_po_details.prepared_by }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">PO Ref.</span>
                                            <span class="col-md-8">@{{ cur_po_details.po_header_id }}</span>
                                        </div>
                                        <div class="row kt-margin-b-5">
                                            <span class="col-md-4 kt-font-bold">Status</span>
                                            <span class="col-md-8">
                                                <span :class="status_colors[cur_po_details.status_name]">@{{ cur_po_details.status_name }}</span>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="addSalesOrder">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>