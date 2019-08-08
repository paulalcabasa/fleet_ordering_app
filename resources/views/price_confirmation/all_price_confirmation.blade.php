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
                    <th>Project No.</th>
                    <th>FPC No.</th>
                    <th>Account Name</th>
                    <th>Date</th>
                    <th>Created by</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fpcList">
                    <!--<td>
                         <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sliders-h"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" :href="base_url + '/price-confirmation-details/' + row.fpc_id">View</a>
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Close</a>
                            <a class="dropdown-item" href="#">Cancel</a>
                            <a class="dropdown-item" href="{{ url('/po-entry/001')}}">Submit PO</a>
                          </div>
                        </div> 
                    </td>-->
                   <td nowrap="nowrap">
                        <a :href="base_url + '/price-confirmation-details/' + row.fpc_id"  title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                    </td>
                    <td>@{{ row.project_id }}</td>
                    <td>@{{ row.fpc_id }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td>@{{ row.date_created }}</td>
                    <td>@{{ row.created_by }}</td>
                    <td nowrap><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>  
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