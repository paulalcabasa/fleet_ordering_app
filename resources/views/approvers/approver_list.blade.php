@extends('_layouts.metronic')

@section('page-title', 'Approvers')

@section('content')
<div id="app">

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                List
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="#" @click="openAddApprover()" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New Approver</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="approver_table" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Approver ID</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Vehicle Type</th>
                    <th>Email Address</th>
                    <th>Hierarchy</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in approvers">
                    <td nowrap>
                        <a href="#" @click="editApprover(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>
                    </td>
                    <td>@{{ row.approver_id }}</td>
                    <td>@{{ row.approver_name }}</td>
                    <td>@{{ row.user_type }}</td>
                    <td>@{{ row.vehicle_type }}</td>
                    <td>@{{ row.email_address }}</td>
                    <td>@{{ row.hierarchy }}</td>
                    <td nowrap>
                        <span class="kt-switch kt-switch--sm kt-switch--icon">
                            <label>
                                <input type="checkbox" @click="updateStatus(row)" :value="row.status" v-model="row.status" :checked="row.status"/>
                                <span></span>
                            </label>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="approverModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <form class="form">
                    <div class="form-group">
                        <label>Name</label>
                        <select class="form-control" v-model="cur_user_id" id="sel_approver" v-select style="width:100%;">
                            <option value="">Choose user</option>
                            <option :value="user.user_id" v-for="user in users" :data-user_source_id="user.user_source_id">@{{ user.first_name + ' ' + user.last_name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vehicle Type</label>
                        <select class="form-control" v-model="cur_vehicle_type" v-select style="width:100%;">
                            <option value="">Choose vehicle type</option>
                            <option value="CV">CV</option>
                            <option value="LCV">LCV</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Approver Type</label>
                        <select class="form-control" v-model="cur_approver_type" v-select style="width:100%;">
                            <option value="">Choose approver type</option>
                            <option value="DLR_MANAGER">Dealer Manager</option>
                            <option value="IPC_MANAGER">IPC Manager</option>
                            <option value="IPC_STAFF">Fleet Staff</option>
                            <option value="IPC_EXPAT">Expat</option>
                            <option value="IPC_SUPERVISOR">Supervisor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Signatory Type</label>
                        <select class="form-control" v-model="cur_signatory_type" v-select style="width:100%;">
                            <option value="">Choose signatory type</option>
                            <option value="NOTED_BY">Noted by</option>
                            <option value="CHECKED_BY">Checked by</option>
                            <option value="EXPAT">EXPAT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <input type="text" class="form-control" v-model="cur_position" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="saveApprover">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</div>
@stop


@push('scripts')
<script>

    function updateFunction (el, binding) {
        // get options from binding value. 
        // v-select="THIS-IS-THE-BINDING-VALUE"
        let options = binding.value || {};

        // set up select2
        $(el).select2(options).on("select2:select", (e) => {
            // v-model looks for
            //  - an event named "change"
            //  - a value with property path "$event.target.value"
            el.dispatchEvent(new Event('change', { target: e.target }));
        });
    }

    Vue.directive('select', {
        inserted: updateFunction ,
        componentUpdated: updateFunction,
    });

    var table;

    var vm =  new Vue({
        el : "#app",
        data: {
            approvers: [],
            status_colors: {!! json_encode($status_colors) !!},
            users: {!! json_encode($users) !!},
            cur_user_id : '',
            cur_vehicle_type : '',
            cur_approver_type : '',
            cur_position : '',
            cur_signatory_type : '',
            action : '',
            cur_approver_id : ''
        },
        methods :{
            updateStatus(row){
                var self = this;
                axios.post('update-approver-status',{
                    approver_id: row.approver_id,
                    status     : row.status
                })
                .then( (response) => {
                    if(row.status){
                        self.toast('success', row.approver_name + ' has been activated!');
                    }
                    else {
                        self.toast('error', row.approver_name + ' has been deactivated');
                    }
                })
                .catch( (error) => {
                    Swal.fire({
                        type: 'error',
                        title: 'System encountered unexpected error.' + error,
                        showConfirmButton: true
                    });
                })
                .finally( (response) => {

                });
            },
            toast(type,message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                });

                Toast.fire({
                    type: type,
                    title: message
                });
            },
            editApprover(row){
                $("#approverModal").modal('show');
                this.cur_user_id        = row.approver_user_id;
                this.cur_vehicle_type   = row.vehicle_type;
                this.cur_approver_type  = row.user_type;
                this.cur_position       = row.position;
                this.cur_signatory_type = row.signatory_type;
                this.action             = "update";
                this.cur_approver_id    = row.approver_id;
            },
            openAddApprover(){    
                $("#approverModal").modal('show');
                this.action = "add";
            },
            saveApprover(){
                if(this.action == 'add'){
                    this.submitData('add-approver');
                }
                else if(this.action == 'update'){
                    this.submitData('update-approver');
                }
            },
            submitData(route){
                var self = this;
                var approver_source_id = $("#sel_approver option:selected").data('user_source_id');
                axios.post(route,{
                    approver_id       : self.cur_approver_id,
                    approver_user_id  : self.cur_user_id,
                    approver_source_id: approver_source_id,
                    vehicle_type      : self.cur_vehicle_type,
                    approver_type     : self.cur_approver_type,
                    position          : self.cur_position,
                    signatory_type    : self.cur_signatory_type
                })
                .then(function (response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Successfully added approver!',
                        showConfirmButton: true,
                        timer: 1500,
                        onClose : function(data){
                            $("#approverModal").modal('hide');
                        }
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        type: 'error',
                        title: 'System encountered unexpected error.' + error,
                        showConfirmButton: true
                    });
                })
                .finally( (response) => {
                    self.loadApprovers();
                });
            },
            loadApprovers(){
                var self = this;
                axios.get('get-approvers')
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#approver_table')){
                            table.destroy();
                        }
                        self.approvers = response.data;
                    })
                    .then( () => {
                        table = $("#approver_table").DataTable({
                            responsive:true
                        });
                    })
                    .catch( (error) => {
                        Swal.fire({
                            type: 'error',
                            title: 'System encountered unexpected error.' + error + ". Please reload the page to continue.",
                            showConfirmButton: true
                        });
                    });
            }
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
            var self = this;
            this.loadApprovers();
        },
        
    });
</script>
@endpush