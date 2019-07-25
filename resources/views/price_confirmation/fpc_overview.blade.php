@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--mobile" >
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Price Confirmation
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a target="_blank" :href="base_url + '/print-fpc-dealer/' + projectDetails.project_id" class="btn btn-primary" >
                <span class="kt-hidden-mobile">Print</span>
            </a>
        </div> 
    </div>
    <div class="kt-portlet__body">
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Project No.</span>
            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ projectDetails.project_id }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Dealer</span>
            <span class="col-md-8 kt-font-bold kt-font-primary">
            @{{ projectDetails.dealer_name }} - @{{ projectDetails.dealer_account}}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Fleet Account Name</span>
            <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.fleet_account_name }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Project Source</span>
            <span class="col-md-8">@{{ projectDetails.project_source }}</span>
        </div>
       
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Date Submitted</span>
            <span class="col-md-8">@{{ projectDetails.date_created }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Submitted By</span>
            <span class="col-md-8">@{{ projectDetails.created_by }}</span>
        </div>
        <div class="row kt-margin-b-5">
            <span class="col-md-4 kt-font-bold">Status</span>
            <span class="col-md-8">
                <span :class="status_colors[projectDetails.status_name]">@{{ projectDetails.status_name }}</span>
            </span>
        </div>
    </div>
</div>



<div class="kt-portlet kt-portlet--height-fluid" v-for="(row,index) in fpcData">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @{{ row['fpc_header'].vehicle_type }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Details</div>
                    <div class="card-body">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Ref No.</span>
                            <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ row['fpc_header'].fpc_id }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Date Created</span>
                            <span class="col-md-8">@{{ row['fpc_header'].date_created }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Prepared By</span>
                            <span class="col-md-8">@{{ row['fpc_header'].prepared_by }}</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Status</span>
                            <span class="col-md-8">
                                <span :class="status_colors[row['fpc_header'].status_name]">@{{ row['fpc_header'].status_name }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Attachment</div>
                    <div class="card-body">
                        <div class="row kt-margin-b-5" v-if="row['attachments'].length > 0">
                            <span class="col-md-4 kt-font-bold">Signed documents</span>
                            <span class="col-md-8">
                                <ul style="list-style:none;padding:0;">
                                    <li v-for="(row,index) in row['attachments']">
                                        <a :href="base_url + '/' + row.directory + '/' +row.filename " download>@{{ row.orig_filename }}</a>
                                    </li>
                                </ul>    
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered table-condensed text-center kt-margin-t-10">
            <thead>
                <tr>
                    <td rowspan="2"></td>
                    <td rowspan="2">Model</td>
                    <td rowspan="2">Color</td>
                    <td rowspan="2">Qty</td>
                    <td rowspan="2">Body Type</td>
                    <td rowspan="2">Unit Price</td>
                    <td rowspan="2">Freebies</td>
                    <td colspan="2">Inclusion</td>
                </tr>
                <tr>
                    <td>STD</td>
                    <td>ADD'L</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, item_index) in row['fpc_lines']">
                    <td>
                        <a href="#" @click.prevent="showDetails(index,item_index)" class="btn btn-primary btn-sm btn-icon btn-circle">
                            <i class="la la-info"></i>
                        </a>
                        </td>
                    </td>
                    <td>@{{ item.sales_model }}</td>
                    <td>@{{ item.color }}</td>
                    <td>@{{ item.quantity }}</td>
                    <td>@{{ item.rear_body_type }}</td>
                    <td align="right">P @{{ item.fleet_price | formatPeso }}</td>
                    <td align="right">@{{ item.freebies | formatPeso }}</td>
                    <td>N/A</td>
                    <td>@{{ item.additional_items }}</td>
                </tr>
            </tbody>
            <tfoot class="kt-font-boldest">
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td> @{{ sumQty(index) }}</td>
                    <td></td>
                    <td colspan="2" align="right">P @{{ sumPrice(index) | formatPeso }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="fpc_details_modal" style="z-index:1131" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched">
                                            <td>@{{ row.delivery_date}}</td> 
                                            <td>@{{ row.quantity }}</td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" v-show="curFreebies.length > 0">
                            <div class="card-header">Freebies</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curFreebies">
                                            <td>@{{ row.description}}</td> 
                                            <td>@{{ row.amount | formatPeso }}</td> 
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th align="right">P @{{ sumFreebies | formatPeso }}</th>
                                        </tr> 
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</div>
@stop


@push('scripts')
<script>

var DatePicker = function(){

    var deliverySchedule = function(){
        $('#txt_delivery_schedule').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    return {
        // public functions
        init: function() {
            deliverySchedule(); 
        }
    };
}();

jQuery(document).ready(function() { 
    DatePicker.init();
});

    var vm =  new Vue({
        el : "#app",
        data: {
            projectDetails  : {!! json_encode($project_details) !!},
            fpcData : {!! json_encode($fpc_data) !!},
            base_url : {!! json_encode($base_url) !!},
            curFreebies : [],
            curDeliverySched : [],
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
        methods : {
           /* formatPrice(value){
                return (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            },*/
            showDetails(header_index,line_index){
                var self                = this;
                var fpc_item_id         = self.fpcData[header_index]['fpc_lines'][line_index].fpc_item_id;
                var requirement_line_id = self.fpcData[header_index]['fpc_lines'][line_index].requirement_line_id;
                axios.get('ajax-get-fpc-details/' + fpc_item_id + '/' + requirement_line_id)
                    .then( (response) => {
                        self.curFreebies = response.data.freebies;
                        self.curDeliverySched = response.data.delivery_sched;   
                        $("#fpc_details_modal").modal('show');
                    });
            },
            sumQty(header_index){
                return this.fpcData[header_index]['fpc_lines'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            sumPrice(header_index){
                return this.fpcData[header_index]['fpc_lines'].reduce((acc,item) => parseFloat(acc) + (parseFloat(item.quantity) * (parseFloat(item.fleet_price) + parseFloat(item.freebies)) ),0);
            }
        },
        mounted : function () {
            
          
        },
        filters: {
            formatPeso: function (value) {
                 return `${parseFloat(value).toLocaleString()}`
            }
        },
        computed : {
            sumFreebies(){
                return this.curFreebies.reduce((acc,item) => parseFloat(acc) + parseFloat(item.amount),0);
            }           
        }
    });


   
</script>
@endpush