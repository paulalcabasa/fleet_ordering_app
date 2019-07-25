@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

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
        <table id="price_confirmation_table" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Project ID</th>
                    <th>Account Name</th>
                    <th>LCV</th>
                    <th>CV</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fpcList">
                    <td>
                        <a :href="base_url + '/fpc-overview/' + row.project_id" class="btn btn-primary  btn-sm btn-icon btn-circle">
                            <i class="la la-eye"></i>
                        </a>
                        <a href="#" class="btn btn-success  btn-sm btn-icon btn-circle"><i class="la la-print"></i></a> 
                    </td>
                    <td>@{{ row.project_id }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td nowrap><span :class="status_colors[row.lcv_status]">@{{ row.lcv_status }}</span></td>
                    <td nowrap><span :class="status_colors[row.cv_status]">@{{ row.cv_status }}</span></td>  
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
            fpcList : {!! json_encode($fpc_list) !!},
            base_url : {!! json_encode($base_url) !!},
            status_colors : {
                'New' : "kt-badge kt-badge--brand kt-badge--inline",
                'Acknowledged' : "kt-badge kt-badge--success kt-badge--inline",
                'Approved' : "kt-badge kt-badge--success kt-badge--inline",
                'Submitted' : "kt-badge kt-badge--warning kt-badge--inline",
                'Cancelled' : "kt-badge kt-badge--danger kt-badge--inline",
                'In progress' : "kt-badge kt-badge--warning kt-badge--inline",
            },
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
          var table = $("#price_confirmation_table").DataTable();
        }
    });
</script>
@endpush