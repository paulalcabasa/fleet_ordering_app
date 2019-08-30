@extends('_layouts.metronic')

@section('page-title', 'Customers')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
         
            <h3 class="kt-portlet__head-title">
                List of Customers
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <div class="dropdown dropdown-inline">
                   
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <label class="kt-checkbox">
                                <input type="checkbox"> Default
                                <span></span>
                            </label>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-print"></i>
                                        <span class="kt-nav__link-text">Print</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-copy"></i>
                                        <span class="kt-nav__link-text">Copy</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                        <span class="kt-nav__link-text">Excel</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                        <span class="kt-nav__link-text">CSV</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                        <span class="kt-nav__link-text">PDF</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- &nbsp;
                    <a href="new-customer" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                        New Customer
                    </a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
            <thead>
                <tr>
                    <th>Account No</th>
                    <th>Account Name</th>
                    <th>Type</th>
                    <th>TIN</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in allCustomers">
                    <td>@{{ row.customer_id }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td>@{{ row.org_type }}</td>
                    <td>@{{ row.tin }}</td>
                    <td>@{{ row.status_id }}</td>
                    <td nowrap>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>
                    </td>
                </tr>              
            </tbody>
        </table>
        <!--end: Datatable -->
    </div>       
</div>

@stop

@push('scripts')
<script>
var KTDatatablesBasicScrollable = function() {

    var initTable1 = function() {
        var table = $('#kt_table_1');
        // begin first table
        table.DataTable({
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                <'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                buttons: [
                    'print',
                    'copyHtml5',
                    'excelHtml5'
                ],
            columnDefs: [
                {
                    targets: 5,
                    title: 'Actions',
                    orderable: false
                    
                },
                {
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: {'title': 'Active', 'class': 'kt-badge--success'},
                            2: {'title': 'Inactive', 'class': ' kt-badge--danger'},
                            3: {'title': 'For Approval', 'class': ' kt-badge--brand'}
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                    },
                }
            ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesBasicScrollable.init();
});
</script>

<script>
    var vm =  new Vue({
        el : "#app",
        data: {
         
            allCustomers : {!! json_encode($all_customers) !!}
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
         
        }
    });
</script>

@endpush