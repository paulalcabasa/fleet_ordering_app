<div class="kt-portlet kt-portlet--mobile" v-if="fpc.length > 0">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Purchase Order
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>PO Ref</th>
                    <th>PO No.</th>
                    <th>Submitted By</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in po_list"> 
                    <td nowrap="nowrap">
                        <a :href="base_url + '/po-overview/view/' + row.po_header_id" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                    </td>
                    <td>@{{ row.po_header_id }}</td>
                    <td>@{{ row.po_number }}</td>
                    <td>@{{ row.created_by }}</td>
                    <td>@{{ row.date_created }}</td>
                    <td>
                        <span class="col-md-8">
                            <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                        </span>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
    <div class="kt-portlet__foot" v-if="projectDetails.status_name == 'Open' && add_po_flag && (user_type == 27 || user_type == 31) ">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                <a 
                    :href="base_url + '/submit-po/' + projectDetails.project_id" 
                    class="btn btn-primary kt-margin-r-5 btn-sm"
                >
                    <span class="kt-hidden-mobile">Add PO</span>
                </a>  
            </div>
        </div>
    </div>
</div>