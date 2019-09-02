@extends('_layouts.metronic')

@section('page-title', 'Users')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet System
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        
        <table id="users_table" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Name</th>
                    <th>Dealer</th>
                    <th>User Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in users">
                   <td nowrap>
                        <!-- <a :href="base_url + '/project-overview/view/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-eye"></i>
                        </a> -->
                        <a v-show="row.user_type_id == 27" href="#" @click.prevent="loadApprover(row.user_id,row.user_source_id, row.customer_id)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Set approver">
                          <i class="la la-cog"></i>
                        </a>
                    </td>
                    <td>@{{ row.first_name + ' ' + row.last_name }}</td>
                    <td>@{{ row.dealer_account }}</td>
                    <td>@{{ row.user_type_name }}</td>
                    <td nowrap>
                        <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    @include('users.modal.approver')
</div>

@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            users:                   {!! json_encode($users) !!},
            base_url:                {!! json_encode($base_url) !!},
            status_colors:           {!! json_encode($status_colors) !!},
            cur_approvers:           [],
            cur_requestor_id:        '',
            cur_requestor_source_id: '',
            cur_customer_id: '',
            cur_dealer_managers:     [],
            selected_dealer_manager : ''
        },
        methods :{
            loadApprover(user_id, user_source_id, customer_id){
                var self = this;
                self.cur_requestor_id = user_id;
                self.cur_requestor_source_id = user_source_id;
                self.cur_customer_id = customer_id;
                axios.get('ajax-get-user-approver', {
                    params : {
                        user_id : user_id,
                        user_source_id : user_source_id,
                        customer_id : customer_id
                    }
                }).then( (response) => {
                    self.cur_approvers = response.data.approvers;
                    self.cur_dealer_managers = response.data.dealer_managers;
                    $("#approverModal").modal('show');
                });
            },
            addApprover(){
                var self = this;
                var approver = self.cur_dealer_managers[self.selected_dealer_manager];

                self.cur_approvers.push({
                    delete_flag:         'N',
                    hierarchy:           1,
                    requestor_source_id: self.cur_requestor_source_id,
                    requestor_user_id:   self.user_id,
                    approver_id:         approver.user_id,
                    approver_source_id:  approver.user_source_id,
                    name : approver.first_name + " " + approver.last_name

                });
            },
            deleteApprover(index){
                var self = this;
                Swal.fire({
                    title: "Confirmation",
                    text: "Are you sure to delete this approver?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'        
                }).then((result) => {
                    if(result.value){
                        Swal.fire({
                            type: 'error',
                            title: 'Approver has been deleted!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        self.cur_approvers.splice(index,1);
                    }
                });
            }
        },
        created: function () {
            // `this` points to the vm instance
        },
        mounted : function () {
           
            var table = $("#users_table").DataTable({
                        // Pagination settings
                        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                        buttons: [
                            'print',
                            'copyHtml5',
                            'excelHtml5'
                        ],
                    });
        }
    });
</script>
@endpush