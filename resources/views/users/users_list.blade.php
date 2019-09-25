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
                    <th>Last login</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in users">
                   <td nowrap>
                        <!-- <a :href="base_url + '/project-overview/view/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-eye"></i>
                        </a> -->
                        <a v-show="row.user_type_name == 'Dealer Staff'" href="#" @click.prevent="loadApprover(row.user_id,row.user_source_id, row.customer_id)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Set approver">
                          <i class="la la-cog"></i>
                        </a>
                    </td>
                    <td>@{{ row.first_name + ' ' + row.last_name }}</td>
                    <td>@{{ row.dealer_account }}</td>
                    <td>@{{ row.user_type_name }}</td>
                    <td>@{{ row.last_login }}</td>
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
            selected_dealer_manager : -1
        },
        methods :{
            loadApprover(user_id, user_source_id, customer_id){
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });
       
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
                    KTApp.unblockPage();
                });
            },
            addApprover(){
                var self = this;
                
                if(self.selected_dealer_manager == -1){
                    Swal.fire({
                        type: 'error',
                        title: "Kindly select an approver.",
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                    return false;
                }
                var approver = self.cur_dealer_managers[self.selected_dealer_manager];

                var isExist = self.cur_approvers.filter(function(elem){
                    if(
                        elem.approver_user_id === approver.user_id
                    ) {
                        return elem.approver_user_id;
                    }
                });

                if(isExist == 0 ){
                    self.cur_approvers.push({
                        hierarchy:           (self.cur_approvers.length+1),
                        requestor_source_id: self.cur_requestor_source_id,
                        requestor_user_id:   self.cur_requestor_id,
                        approver_user_id:    approver.user_id,
                        approver_source_id:  approver.user_source_id,
                        name:                approver.first_name + " " + approver.last_name,
                        approver_id:         -1,
                        status_id:           1,
                        status:              true
                    });
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: "Approver already exists!",
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                }
            },
            saveApprover(){
                var self = this;
                var is_error = self.cur_approvers.filter(function(elem){
                    if(
                        elem.hierarchy > 90
                    ) {
                        return elem.hierarchy;
                    }
                });
                if(is_error.length > 0){

                    Swal.fire({
                        type: 'error',
                        title: "Please check the hierarchy, maximum value is until 90 only.",
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                    return false;
                }

                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.post('save-user-approver',{
                    approvers : self.cur_approvers
                }).then( (response) => {
                    Swal.fire({
                        type: 'success',
                        title: "Approvers has been updated!",
                        showConfirmButton: true,
                        timer: 1500
                    }).then( (response) => {
                        $("#approverModal").modal('hide');
                        KTApp.unblockPage();
                    }); 
                });
            },
            updateStatus(index){
                var self = this;
                if(!self.cur_approvers[index].status){
                    self.cur_approvers[index].status_id = 1;
                }
                else {
                    self.cur_approvers[index].status_id = 2;
                }
            },
            deleteApprover(index){
                this.cur_approvers.splice(index,1);
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
                        responsive:true
                    });
        }
    });
</script>
@endpush