@extends('_layouts.metronic')

@section('page-title', 'Purchase Order')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                PO List
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
	   <table class="table table-bordered table-striped" width="100%" id="po_table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>PO Number</th>
                    <th>Project No</th>
                    <th>Customer</th>
                    <th>Date Submitted</th>
                    <th>Submitted by</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in po_list">
                    <td nowrap>
                        <a :href="base_url + '/po-overview/view/' + row.po_header_id" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
                    </td>
                    <td>@{{ row.po_number }}</td>
                    <td>@{{ row.project_id }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.date_created }}</td>
                    <td>@{{ row.created_by }}</td>
                    <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
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
            po_list:       {!! json_encode($po_list) !!},
            status_colors: {!! json_encode($status_colors) !!},
            base_url:      {!! json_encode($base_url) !!},
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
                var table = $("#po_table").DataTable({
                    dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                    <'row'<'col-sm-12'tr>>
                    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                    buttons: [
                        'print',
                        'copyHtml5',
                        'excelHtml5'
                    ]
                });
        }
    });
</script>
@endpush