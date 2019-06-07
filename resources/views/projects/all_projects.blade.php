@extends('_layouts.metronic')

@section('page-title', 'Fleet Projects')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                All Projects
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-bordered table-striped" width="100%" id="projects_table">
            <thead>
                <tr>
                    <th>Account No.</th>
                    <th>Project No.</th>
                    <th>Account Name</th>
                    <th>Requested By</th>
                    <th>Date Requested</th>
                    <th>Dealer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in tableData">
                    <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sliders-h"></i>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if( strtolower(session('user')['user_type_name']) != "dealer")
                            <a class="dropdown-item" href="{{ url('project-overview/validate/001') }}">Validate</a>
                            @endif
                            <a class="dropdown-item" href="{{ url('project-overview/view/001') }}">Overview</a>
                            <a class="dropdown-item" href="{{ url('manage-project/edit/001') }}">Edit</a>
                            <a class="dropdown-item" href="{{ url('project-overview/cancel/001') }}">Cancel</a>
                            <div class="dropdown-divider"></div>
                           <!--  @if(session('user')['user_type_name'] == 'Dealer')
                            <a class="dropdown-item" href="{{ url('view-fpc/10') }}">Price Confirmation</a>
                            @elseif(session('user')['user_type_name'] == 'Administrator')
                            <a class="dropdown-item" href="{{ url('price-confirmation-details/10') }}">Price Confirmation</a>
                            @endif -->
                            <a class="dropdown-item" href="{{ url('/manage-po/create/001')}}">Submit PO</a>
                           </div>
                        </div>
                    </td>
                    <td>@{{ row.id }}</td>
                    <td nowrap>@{{ row.account_name }}</td>
                    <td>@{{ row.requestor }}</td>
                    <td>@{{ row.date_requested }}</td>
                    <td>@{{ row.dealer }}</td>
                    <td nowrap><span :class="status_colors['new']">@{{ row.status }}</span></td>
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
                    "requestor" : "RYAN SENIA",
                    "date_requested" : "04/01/2019",
                    "dealer" : "PASIG",
                    "status" : "New"
                },
                {
                    "id" : "002",
                    "account_name" : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    "requestor" : "JOHN CONSTANTINE",
                    "date_requested" : "04/01/2019",
                    "dealer" : "MAKATI",
                    "status" : "For_Approval"
                },
                {
                    "id" : "003",
                    "account_name" : "DULCEGARII INC.",
                    "requestor" : "JINKY ABELLA ",
                    "date_requested" : "04/01/2019",
                    "dealer" : "ALABANG",
                    "status" : "Approved"
                },
                {
                    "id" : "003",
                    "account_name" : "POWER EQUIPMENT & SUPPLIES INC.",
                    "requestor" : "JOJO CONDE",
                    "date_requested" : "04/01/2019",
                    "dealer" : "COMMONWEALTH",
                    "status" : "Price_Confirmed"
                },
                {
                    "id" : "003",
                    "account_name" : "LIFE BASIC TRADING",
                    "requestor" : "CHARLES SIA ",
                    "date_requested" : "04/01/2019",
                    "dealer" : "CAGAYAN",
                    "status" : "Awaiting_FWPC"
                },
                {
                    "id" : "003",
                    "account_name" : "LIFE BASIC TRADING",
                    "requestor" : "CHARLES SIA ",
                    "date_requested" : "04/01/2019",
                    "dealer" : "CAGAYAN",
                    "status" : "Closed"
                },
                {
                    "id" : "003",
                    "account_name" : "LIFE BASIC TRADING",
                    "requestor" : "CHARLES SIA ",
                    "date_requested" : "04/01/2019",
                    "dealer" : "CAGAYAN",
                    "status" : "Cancelled"
                },
            ],
            status_colors : []
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
            viewPriceConfirmation(){
                window.location.href = 'price-confirmation-details/10';
            }
        },
        mounted : function () {
            var table = $("#projects_table").DataTable();
            this.status_colors['new'] = "kt-badge kt-badge--brand kt-badge--inline";
            
            /* "New"
                    status : "New",
                    class : "kt-badge kt-badge--brand kt-badge--inline"
                }
          /*      "For_Approval" : "kt-badge kt-badge--warning kt-badge--inline",
                "Approved" : "kt-badge kt-badge--success kt-badge--inline",
                "Price_Confirmed" : "kt-badge kt-badge--primary kt-badge--inline",
                "Awaiting_FWPC" : "kt-badge kt-badge--warning kt-badge--inline",
                "Cancelled" : "kt-badge kt-badge--danger kt-badge--inline",
                "Closed" : "kt-badge kt-badge--secondary kt-badge--inline"*/ 
        }
    });
</script>
@endpush