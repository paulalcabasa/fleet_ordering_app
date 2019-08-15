<div class="kt-portlet kt-portlet--mobile" v-if="fpc.length > 0">
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
                    <th>FPC Ref No.</th>
                    <th>Sales Order No.</th>
                    <th>Ordered Date</th>
                    <th>Customer Name</th>
                    <th>Order Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fwpc"> 
                    <td nowrap="nowrap">
                        <a href="#" title="View" @click.prevent="viewFwpc(index)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                        <a target="_blank" :href="base_url + '/print-fwpc/' + row.fwpc_id" title="Print" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-print"></i></a>
                        <a href="#" title="Delete" @click.prevent="deleteFwpc(index)" v-if="(user_type == 32 || user_type == 33) && projectDetails.status_name != 'Closed'" title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-trash"></i></a>
                    </td>
                    <td>@{{ row.fpc_project_id }}</td>
                    <td>@{{ row.order_number }}</td>
                    <td>@{{ row.ordered_date }}</td>
                    <td>@{{ row.party_name }} - @{{ row.account_name }}</td>
                    <td>@{{ row.order_type_name }}</td>
                    <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
   <!--  <div class="kt-portlet__foot" v-if="(user_type == 32 || user_type == 33) && projectDetails.status_name != 'Closed'">
        <div class="row kt-pull-right">
            <div class="col-lg-12">
                 <a href="#"  data-toggle="modal" data-target="#addFWPC" class="btn btn-primary btn-sm">
                    <span class="kt-hidden-mobile">Add FWPC</span>
                </a>  
            </div>
        </div>
    </div> -->
</div>