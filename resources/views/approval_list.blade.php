@extends('_layouts.metronic')

@section('page-title', 'Approval')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                List
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="datatable" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Ref No.</th>
                    <th>Type</th>
                    <th>Project No.</th>
                    <th>Account Name</th>
                    <th>Dealer</th>
                    <th>Prepared by</th>
                    <th>Date created</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in approval_list">
                    <td nowrap>
                        <a :href="getApprovalLink(row)" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
                     </td>
                    <td>@{{ row.approval_id }}</td>
                    <td>@{{ row.type }}</td>
                    <td>@{{ row.project_id }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.dealer_name }}</td>
                    <td>@{{ row.created_by }}</td>
                    <td>@{{ row.date_submitted }}</td>
                    <td nowrap>
                        <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            approval_list: {!! json_encode($approval_list) !!},
            base_url:      {!! json_encode($base_url) !!},
            status_colors: {!! json_encode($status_colors) !!}
        },
        methods :{
            getApprovalLink(row){
                var self = this;
                switch(row.type){
                    case 'PO' : 
                        return self.base_url + '/po-overview/validate/' + row.module_reference_id + '/' + row.approval_id; 
                    break;

                    case 'Project' :
                        return self.base_url + '/project-overview/validate/' + row.project_id + '/' + row.approval_id; 
                    break;

                    case 'FPC Extension' :
                        return self.base_url + '/project-overview/view/' + row.project_id; 
                    break;
                }
            }
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
            var table = $("#datatable").DataTable({
                responsive:true
            });
        }
    });
</script>
@endpush