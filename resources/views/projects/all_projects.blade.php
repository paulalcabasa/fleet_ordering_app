@extends('_layouts.metronic')

@section('page-title', 'Fleet Projects')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                All Projects
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
 
        <table class="table table-bordered table-striped" style="font-size:90%;" width="100%" id="projects_table">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Project No.</th>
                    <th>Account Name</th>
                    <th>Dealer</th>
                    <th>Status</th>
                    <th>FPC</th>
                    <th>PO</th>
                    <th>FWPC</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in projects">
                    <td nowrap>
                        <a :href="base_url + '/project-overview/view/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-eye"></i>
                        </a>
                       <!--  <a v-if="row.fpc_status == 'good'" :href="base_url + '/submit-po/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-file-text"></i>
                        </a>
 -->


                       <!--  <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a> -->
                        <!-- <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sliders-h"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" :href="base_url + '/project-overview/view/' + row.project_id">Overview</a>
                            <a class="dropdown-item" href="#" @click.prevent="showApproval(row)">View Approval</a>
                            <a class="dropdown-item" href="{{ url('manage-project/edit/001') }}">Edit</a>
                            <a class="dropdown-item" href="{{ url('project-overview/cancel/001') }}">Cancel</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/manage-po/create/001')}}">Submit PO</a>
                           </div>
                        </div> -->
                    </td>
                    <td>@{{ row.project_id }}</td>
                    <td nowrap>@{{ row.customer_name }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td nowrap @click.prevent="showApproval(row)" style="cursor:pointer;">
                        <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                    </td>
                    <td><i class="fa fa-check kt-font-success" v-if="row.fpc_status == 'good'"></i></td>
                    <td><i class="fa fa-check kt-font-success" v-if="row.po_status == 'good'"></i></td>
                    <td><i class="fa fa-check kt-font-success" v-if="row.fwpc_status == 'good'"></i></td>
                 
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approval Workflow</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Approver</th>
                                <th>Status</th>
                                <th>Date Approved</th>
                            </tr>    
                        </thead>
                        <tbody>
                            <tr v-for="(row,index) in cur_approval">
                                <td>@{{ row.approver_name }}</td>
                                <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
                                <td>@{{ row.date_approved }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            projects:    {!! json_encode($projects) !!},
            base_url:    {!! json_encode($base_url) !!},
            status_colors : {!! json_encode($status_colors) !!},
            cur_approval : []
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
            viewPriceConfirmation(){
                window.location.href = 'price-confirmation-details/10';
            },
            showApproval(row){
                var self = this;
                axios.get('/ajax-get-approval-workflow/' + row.project_id)
                .then(function(response){
                    self.cur_approval = response.data;
                })
                .catch(function(error){
                    console.log(error);
                })
                .finally(function(){

                });
                $("#modal_approver").modal('show');
            }
        },
        mounted : function () {
            var table = $("#projects_table").DataTable();
        }
    });
</script>
@endpush