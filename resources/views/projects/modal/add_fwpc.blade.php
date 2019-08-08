<!--begin::Modal-->
<div class="modal fade" id="addFWPC" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add FWPC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">   
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" v-model="cur_sales_order_number" class="form-control" placeholder="Search for sales order number...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" @click="searchSalesOrder">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card kt-margin-t-10" v-show="cur_so_details.hasOwnProperty('order_number')">
                        <div class="card-header kt-font-boldest">Sales Order Details</div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="addSalesOrder">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->