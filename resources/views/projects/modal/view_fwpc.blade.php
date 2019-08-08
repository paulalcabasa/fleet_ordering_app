<!--begin::Modal-->
<div class="modal fade" id="viewFWPC" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FWPC Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">   
                <div class="card kt-margin-b-10">
                    <div class="card-header kt-font-bold">Sales Order Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Sales Order No.</span>
                                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ cur_so_header.order_number }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Customer Name</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.party_name }}
                                        <span class="kt-badge kt-badge--inline kt-badge--success">@{{ cur_so_header.account_name }}</span>
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Customer Type</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.profile_class }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Ordered Date</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.ordered_date }}
                                    </span> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Order Type</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.order_type_name }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Price List</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.price_list_name }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Payment Term</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.payment_term }}
                                    </span> 
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Status</span>
                                    <span class="col-md-8">
                                        @{{ cur_so_header.flow_status_code }}
                                    </span> 
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="card">
                    <div class="card-header kt-font-bold">Sales Order Lines</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Model</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in cur_so_lines">
                                    <td>@{{ index + 1 }}</td>
                                    <td>@{{ row.sales_model }}</td>
                                    <td>@{{ row.color }}</td>
                                    <td>@{{ row.unit_list_price }}</td>
                                    <td>@{{ row.quantity }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->