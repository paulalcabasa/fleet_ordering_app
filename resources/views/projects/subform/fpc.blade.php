<div class="alert alert-info" role="alert" v-for="(row,index) in pending_fpc_vehicle_type" v-if="projectDetails.status_name == 'Open'">
    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
    <div class="alert-text">Awaiting Fleet Price Confirmation for @{{ row }}.</div>
</div>

<div class="kt-portlet kt-portlet--height-fluid" v-for="(row,index) in fpc" >
   
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Price Confirmation <small>@{{ row['fpc_header'].vehicle_type }}</small>
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-12">

                <div class="alert alert-warning fade show" role="alert" v-for="data in row['pending_fpc_validity']">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">Pending request for validity extension.</div>
                    <div class="alert-close">
                        <button type="button" class="btn btn-danger btn-sm" @click="viewRequestDetails(data,row['fpc_header'])">
                           View details
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Details</div>
                    <div class="card-body">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Ref No.</span>
                            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ row['fpc_header'].fpc_project_id }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Validity</span>
                            <span class="col-md-8">@{{ row['fpc_header'].validity }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Date Created</span>
                            <span class="col-md-8">@{{ row['fpc_header'].date_created }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Prepared By</span>
                            <span class="col-md-8">@{{ row['fpc_header'].prepared_by }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Status</span>
                            <span class="col-md-8">
                                <span :class="status_colors[row['fpc_header'].status_name]">@{{ row['fpc_header'].status_name }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Attachment</div>
                    <div class="card-body">
                        <div class="row kt-margin-b-5" v-if="row['attachments'].length > 0">
                            <span class="col-md-4 kt-font-bold">Signed documents</span>
                            <span class="col-md-8">
                                <ul style="list-style:none;padding:0;">
                                    <li v-for="(row,index) in row['attachments']">
                                        <a :href="base_url + '/' + row.symlink_dir +row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>    
                            </span>
                        </div>
                        <div class="row kt-margin-b-5" v-if="row['fpc_header'].status_name == 'Approved'">
                            <span class="col-md-4 kt-font-bold">Digital FPC</span>
                            <span class="col-md-8">
                        
                                <a :href="base_url + '/' + 'api/fpc/print/dealer/' + row['fpc_header'].fpc_project_id ">Click here to print</a>
                                       
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed kt-margin-t-10">
                <thead>
                    <tr>
                        <td rowspan="2"></td>
                        <td rowspan="2">Model</td>
                        <td rowspan="2">Color</td>
                        <td rowspan="2">Qty</td>
                        <td rowspan="2">Body Type</td>
                        <td rowspan="2">Unit Price</td>
                        <td rowspan="2">Freebies</td>
                        <td>Inclusions</td>
                    </tr>
                    <tr>
                    <!--     <td>STD</td> -->
                        <td>ADD'L</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, item_index) in row['fpc_lines']">
                        <td>
                            <a href="#" @click.prevent="showDetails(index,item_index)" class="btn btn-primary btn-sm btn-icon btn-circle">
                                <i class="la la-info"></i>
                            </a>
                            </td>
                        </td>
                        <td>@{{ item.sales_model }}</td>
                        <td><span :class="vehicle_colors[item.color]">&nbsp</span> @{{ item.color }}</td>
                        <td>@{{ item.quantity }}</td>
                        <td>@{{ item.rear_body_type }}</td>
                        <td align="right">P @{{ item.suggested_retail_price - item.discount - item.promo | formatPeso }}</td>

                        <td align="right">@{{ item.freebies | formatPeso }}</td>
                        <!-- <td>N/A</td> -->
                        <td>@{{ item.additional_items }}</td>
                    </tr>
                </tbody>
                <tfoot class="kt-font-boldest">
                    <tr>
                        <td colspan="3" align="right">Total</td>
                        <td> @{{ sumQty(index) }}</td>
                        <td></td>
                        <td colspan="4" align="right">P @{{ sumPrice(index) | formatPeso }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
        <div class="col-lg-12">
            <button 
                type="button" 
                class="btn btn-primary btn-sm"
                @click="requestExtension(row['fpc_header'])"
                v-if="user_type == 27 || user_type == 31"
            >
                Request for extension
            </button>  
            <a 
                href="#"
                class="btn btn-primary btn-sm"
                @click.prevent="printFPC(projectDetails.project_id,row['fpc_header'].fpc_id,row['fpc_header'].fpc_project_id)"
                
            >
                <span class="kt-hidden-mobile">Print</span>
            </a>
        </div>
        </div>
    </div>


    
</div>