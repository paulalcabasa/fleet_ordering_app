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
            <a href="#" data-target="#approverModal" data-toggle="modal" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New Approver</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="datatable" class="table table-striped" width="100%">
            <thead>
                <tr>
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
                <h5 class="modal-title" id="exampleModalLabel">New Approver</h5>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="addApprover">Save</button>
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

    var vm =  new Vue({
        el : "#app",
        data: {
            approvers: {!! json_encode($approvers) !!},
            status_colors: {!! json_encode($status_colors) !!},
            users: {!! json_encode($users) !!},
            cur_user_id : '',
            cur_vehicle_type : '',
            cur_approver_type : ''
        },
        methods :{
            addApprover(){
                var self = this;
                var approver_source_id = $("#sel_approver option:selected").data('user_source_id');
                axios.post('add-approver',{
                    approver_user_id  : self.cur_user_id,
                    approver_source_id: approver_source_id,
                    vehicle_type      : self.cur_vehicle_type,
                    approver_type     : self.cur_approver_type
                })
                .then(function (response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Successfully added approver!',
                        showConfirmButton: true,
                        timer: 1500,
                        onClose : function(data){
                            window.location.reload();
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

                });
            },
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
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
            var table = $("#datatable").DataTable({
                responsive:true
            });
        },

        
    });
</script>
@endpush