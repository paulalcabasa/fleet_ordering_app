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
                    <th>Project Name</th>
                    <th>Date Submitted</th>
                    <th>Dealer</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in po_list">
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sliders-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ url('/manage-po/view/001') }}">View Details</a>       
                                <a class="dropdown-item" href="{{ url('/manage-po/validate/001') }}">Validate</a>                            
                            </div>
                        </div>
                    </td>
                    <td>@{{ row.po_number }}</td>
                    <td>@{{ row.project_number }}</td>
                    <td>@{{ row.project_name }}</td>
                    <td>@{{ row.date_submitted }}</td>
                    <td>@{{ row.submitted_by }}</td>
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
            po_list : [
                {
                    po_number : 'PO001',
                    project_number : 'PRJ001',
                    project_name : 'RCP SENIA TRADING/ RCP SENIA TRANSPORT',
                    date_submitted : 'May 01, 2019',
                    submitted_by : 'PASIG'
                }
            ]
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
                var table = $("#po_table").DataTable();
        }
    });
</script>
@endpush