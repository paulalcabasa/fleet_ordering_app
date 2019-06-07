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
                    <th>FPC No. </th>
                    <th>Account Name</th>
                    <th>Date Created</th>
                    <th>Prepared By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in tableData">
                    <td>@{{ row.fpc_no }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.date_created }}</td>
                    <td>@{{ row.prepared_by }}</td>
                    <td nowrap>
                        <a href="{{ url('fpc-details/validate/001') }}" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
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
            tableData : [
                {
                    "fpc_no" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "date_created" : "May 31, 2019",
                    "prepared_by" : "John Doe"

                },
                {
                    "fpc_no" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "date_created" : "May 31, 2019",
                    "prepared_by" : "John Doe"

                },
                {
                    "fpc_no" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "date_created" : "May 31, 2019",
                    "prepared_by" : "John Doe"

                },
                {
                    "fpc_no" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "date_created" : "May 31, 2019",
                    "prepared_by" : "John Doe"

                },
                {
                    "fpc_no" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "date_created" : "May 31, 2019",
                    "prepared_by" : "John Doe"

                }
            ]
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