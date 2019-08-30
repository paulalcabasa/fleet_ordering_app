@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">
    <div class="kt-portlet kt-portlet--collapsed" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Filters
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
                    <a href="#" data-ktportlet-tool="remove" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-close"></i></a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group row" style="margin-bottom:1em !important;">
                        <label class="col-3  col-form-label">Order Date : </label>
                        <div class="col-4">
                            <input type="date" class="form-control" name="" v-model="start_date">
                        </div>
                        <div class="col-4">
                            <input type="date" class="form-control" name="" v-model="end_date">
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:1em !important;">
                        <label class="col-3  col-form-label">FWPC Status : </label>
                        <div class="col-9">
                            <select class="custom-select form-control">
                                <option selected value="">Select status</option>
                                <option value="4">Approved</option>
                                <option value="7">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:1em !important;">
                        <label class="col-3"></label>
                        <div class="col-9">
                            <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                                <input type="checkbox" v-model="uninvoiced_flag" /> Show only uninvoiced orders
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row" style="margin-bottom:1em !important;">
                        <label class="col-3"></label>
                        <div class="col-9 ">
                            <button type="button" class="btn btn-info btn-sm" @click="filterFWPC()">Filter</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                </div>
            </div>
            </div>
        </div>
    </div>  

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    FWPC List
                </h3>
            </div>
            
        </div>
        <div class="kt-portlet__body">    
            <table id="price_confirmation_table" class="display table table-bordered  nowrap" style="width:100%" >
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Line No.</th>
                        <th>Sales Model</th>
                        <th>Color</th>
                        <th>Invoice No.</th>
                        <th>CS No.</th>
                        <th>FWPC No.</th>
                        <th>Project No.</th>
                        <th>Vehicle Type</th>
                        <th>Dealer</th>
                        <th>Fleet Account</th>
                        <th>Ordered Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row,index) in fwpc_list">
                        <td>@{{ row.order_number }}</td>
                        <td>@{{ row.line_number }}</td>
                        <td>@{{ row.sales_model }}</td>
                        <td>@{{ row.color }}</td>
                        <td>@{{ row.trx_number }}</td>
                        <td>@{{ row.cs_no }}</td>  
                        <td>@{{ row.fwpc_id }}</td>
                        <td>@{{ row.project_id }}</td>
                        <td>@{{ row.vehicle_type }}</td>
                        <td>@{{ row.account_name }}</td>
                        <td>@{{ row.fleet_account_name }}</td>
                        <td>@{{ row.ordered_date | formatDate }}</td>
                        <td>@{{ row.fwpc_status }}</td>
                    </tr>
                </tbody>
            </table>  
    </div>
</div>
@stop


@push('scripts')
<script>    

    var table;


    var vm =  new Vue({
        el : "#app",
        data: {
            fwpc_list : [],
            start_date : '',
            end_date : '',
            uninvoiced_flag : '',
            fwpc_status : ''
        },
        created: function () {

        },
        mounted : function () {
            var self = this;
        
            if(localStorage.getItem('fwpc_start_date')){
                self.start_date = localStorage.getItem('fwpc_start_date');
            } 
            if(localStorage.getItem('fwpc_end_date')){
                self.end_date = localStorage.getItem('fwpc_end_date');
            }
            if(localStorage.getItem('uninvoiced_flag')){
                self.uninvoiced_flag = localStorage.getItem('uninvoiced_flag');
            } 
            if(localStorage.getItem('fwpc_status')){
                self.fwpc_status = localStorage.getItem('fwpc_status');
            } 
            

            self.supplyFWPC();  
  
        },
        methods : {
            supplyFWPC(){
                var self = this;
           
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                // supply fwpc table
                axios.get('get-all-fwpc', {
                    params : {
                        start_date : self.start_date,
                        end_date : self.end_date,
                        uninvoiced_flag : self.uninvoiced_flag,
                        fwpc_status : self.fwpc_status
                    }
                }).then( (response) => {
                    if($.fn.dataTable.isDataTable('#price_confirmation_table')){
                        table.destroy();
                    }
                    self.fwpc_list = response.data;
                }).then( (response) => {
                    table = $("#price_confirmation_table").DataTable({
                        order : [],
                        // Pagination settings
                        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                        buttons: [
                            'print',
                            'copyHtml5',
                            'excelHtml5'
                        ],
                        initComplete: function (settings, json) {  
                            $("#price_confirmation_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        }
                    });
                }).finally( (response) => {
                    KTApp.unblockPage();
                }); 
            },
            filterFWPC(){
                this.supplyFWPC();
            }
        },
        watch : {
            start_date : function(val){
                localStorage.setItem('fwpc_start_date' , val);
            },
            end_date : function(val){
                localStorage.setItem('fwpc_end_date' , val);
            },
            uninvoiced_flag : function(val){
                localStorage.setItem('uninvoiced_flag' , val);
            },
            fwpc_status : function(val){
                localStorage.setItem('fwpc_status' , val);
            }
        },
        filters : {
            formatDate(value){
                return moment(String(value)).format('MM/DD/YYYY hh:mm');
            }
        }
    });
</script>
@endpush

