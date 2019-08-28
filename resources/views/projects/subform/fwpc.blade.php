<div class="kt-portlet kt-portlet--mobile" v-if="po_list.length > 0">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Wholesale Price Confirmation
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>Action</th>
                    <!-- <th>PO Ref No.</th>
                    <th>FPC Ref No.</th> -->
                    <!-- <th>Customer Name</th> -->
                    <!-- <th>Ordered Date</th> -->
                    <th>Vehicle Type</th>
                    <th>FPWC No.</th>
                    <th>Sales Order No.</th>
                    <th>Signed IPC FWPC</th>
                    <th>Signed Dealer FWPC</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fwpc"> 
                    <td nowrap="nowrap">
                        <div class="dropdown dropdown-inline">
                            <button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md btn-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="flaticon-more-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                                <a class="dropdown-item" href="#" @click.prevent="viewFwpc(index)"><i class="la la-eye"></i> View details</a>
                                <a class="dropdown-item" :href="base_url + '/print-fwpc/' + row.fwpc_id" target="_blank"><i class="la la-print"></i> Print</a>
                                <a class="dropdown-item" href="#" @click.prevent="triggerFileUpload(index)" v-if="row.status_name != 'Approved' && (user_type == 27 || user_type == 31)"><i class="la la-cloud-upload"></i> Upload signed document</a>
                                <a class="dropdown-item" href="#" @click.prevent="triggerFileUpload(index)" v-if="row.status_name != 'Approved' && vehicle_user_type == row.vehicle_type"><i class="la la-cloud-upload"></i> Upload signed document</a>
                                
                             <!--    <div class="dropdown-divider" 
                                    v-if="(user_type == 32 || user_type == 33) && row.dlr_file_orig != null && row.status_name != 'Approved'"
                                ></div> -->
                                <a class="dropdown-item" href="#" @click.prevent="validateFWPC(index,'approve')" v-if="(user_type == 32 || user_type == 33) && row.dlr_file_orig != null && row.status_name != 'Approved' && row.vehicle_type == vehicle_user_type"><i class="la la-check"></i> Approve</a>
                                <a class="dropdown-item" href="#" @click.prevent="validateFWPC(index,'reject')" v-if="(user_type == 32 || user_type == 33) && row.dlr_file_orig != null && row.status_name != 'Approved' && row.vehicle_type == vehicle_user_type"><i class="la la-remove"></i> Reject dealer document</a>
                                <!-- <div class="dropdown-divider" v-if="(user_type == 32 || user_type == 33) && row.status_name != 'Approved'"></div> -->
                                <a class="dropdown-item" href="#" @click.prevent="deleteFwpc(index)" v-if="(user_type == 32 || user_type == 33) && row.status_name != 'Approved' && row.vehicle_type == vehicle_user_type"><i class="la la-trash"></i> Delete</a>
                            </div>
                        </div> 
                    </td>
                    <!-- <td>@{{ row.fpc_project_id }}</td> -->
                    <!-- <td>@{{ row.po_header_id }}</td> -->
                    <!-- <td>@{{ row.party_name }} - @{{ row.account_name }}</td> -->
                    <!-- <td>@{{ row.ordered_date }}</td>
                    <td>@{{ row.order_type_name }}</td> -->
                    <td>@{{ row.vehicle_type }}</td>
                    <td>@{{ row.fwpc_id }}</td>
                    <td>@{{ row.order_number }}</td>
                    <td><a :href="base_url + '/' + row.ipc_file" download>@{{ row.ipc_file_orig }}</a></td>
                    <td><a :href="base_url + '/' + row.dlr_file" download>@{{ row.dlr_file_orig }}</a></td>
                    <td>
                        <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="kt-portlet__foot" v-if="(user_type == 32 || user_type == 33) && projectDetails.status_name != 'Closed'">
        <div class="row kt-pull-right">
            <div class="col-lg-12">
                 <a href="#"  data-toggle="modal" data-target="#addFWPC" class="btn btn-primary btn-sm">
                    <span class="kt-hidden-mobile">Add FWPC</span>
                </a>  
            </div>
        </div>
    </div> 
</div>

<input type="file" v-show="false" @change="uploadDocument" ref="signed_fwpc" name="signed_fwpc" id="signed_fwpc">
