@extends('_layouts.metronic')

@section('page-title', 'Customer')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Details
            </h3>
        </div>
        
    </div>
    <div class="kt-portlet__body"> 
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Account No</span>
            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ customer_details.customer_id }}</span>
        </div> 
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Customer Name</span>
            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ customer_details.customer_name }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">TIN</span>
            <span class="col-md-8">@{{ customer_details.tin }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Business Style</span>
            <span class="col-md-8">@{{ customer_details.business_style }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Address</span>
            <span class="col-md-8">@{{ customer_details.address }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Organization Type</span>
            <span class="col-md-8">@{{ customer_details.org_type_name }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Company Overview</span>
            <span class="col-md-8">@{{ customer_details.company_overview }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Establishment Date</span>
            <span class="col-md-8">@{{ customer_details.establishment_date }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Products</span>
            <span class="col-md-8">@{{ customer_details.products }}</span>
        </div>

        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Affiliates</span>
            <span class="col-md-8">
                <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                    <li v-for="(row,index) in affiliates">
                         @{{ row.customer_name }}
                    </li>
                </ul>
            </span>
        </div>

        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Attachments</span>
            <span class="col-md-8">
                <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                    <li v-for="(row,index) in attachments">
                        <a target="_blank" :href="baseUrl + '/' + row.symlink_dir + '/' + row.filename" download v-if="row.directory != null">@{{ row.orig_filename }}</a>
                        <span v-if="row.directory == null">@{{ row.orig_filename }}</span>
                    </li>
                </ul>
            </span>
        </div>

    </div>       
</div>

@stop

@push('scripts')
<script>

</script>

<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            customer_details: {!! json_encode($customer_details) !!},
            attachments     : {!! json_encode($attachments) !!},
            affiliates      : {!! json_encode($affiliates) !!},
            baseUrl      : {!! json_encode($baseUrl) !!},
        },
        created: function () {
            // `this` points to the vm instance
        },
        mounted : function () {
            
        }
    });
</script>

@endpush