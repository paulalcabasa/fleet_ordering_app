@extends('_layouts.metronic')

@section('page-title', 'Approval')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                FPC Approval
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="datatable" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>FPC No.</th>
                    <th>Fleet Account Name</th>
                    <th>Pending approval from</th>
                    <th>Prepared by</th>
                    <th>Date created</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in approval_list">
                    <td nowrap>
                        <a href="#" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
                     </td>
                    <td>@{{ row.fpc_id }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td>@{{ row.subordinate }}</td>
                    <td>@{{ row.prepared_by }}</td>
                    <td>@{{ row.date_created }}</td>
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