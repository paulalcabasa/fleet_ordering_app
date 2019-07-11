@extends('_layouts.metronic')

@section('page-title', 'Project Approval')

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
                    <th>Approval Reference</th>
                    <th>Project No.</th>
                    <th>Account Name</th>
                    <th>Prepared by</th>
                    <th>Date created</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in approval_list">
                    <td>@{{ row.approval_id }}</td>
                    <td>@{{ row.project_id }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.created_by }}</td>
                    <td>@{{ row.date_submitted }}</td>
                    <td nowrap><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
                    <td nowrap>
                        <a :href="base_url + '/project-overview/validate/' + row.project_id + '/' + row.approval_id" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
                        <a href="#" class="btn btn-success  btn-sm btn-icon btn-circle"><i class="la la-print"></i></a> 
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
            approval_list : {!! json_encode($approval_list) !!},
            base_url : {!! json_encode($base_url) !!},
            status_colors : {
                'New' : "kt-badge kt-badge--brand kt-badge--inline",
                'Acknowledged' : "kt-badge kt-badge--success kt-badge--inline",
                'Submitted' : "kt-badge kt-badge--warning kt-badge--inline",
                'Cancelled' : "kt-badge kt-badge--danger kt-badge--inline",
            }
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
            var table = $("#datatable").DataTable();
        }
    });
</script>
@endpush