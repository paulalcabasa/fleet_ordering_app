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
                    <th>FPC No.</th>
                    <th>Account Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in tableData">
                    <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sliders-h"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item btn-test" href="{{ url('price-confirmation-details/validate/10') }}">Validate</a>
                            <a class="dropdown-item btn-test" href="{{ url('price-confirmation-details/10') }}">View</a>
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Close</a>
                            <a class="dropdown-item" href="#">Cancel</a>
                            <a class="dropdown-item" href="{{ url('/po-entry/001')}}">Submit PO</a>
                          </div>
                        </div>
                    </td>
                    <td>@{{ row.id }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.status }}</td>
                  
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
                    "id" : "001",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "status" : "Open"
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