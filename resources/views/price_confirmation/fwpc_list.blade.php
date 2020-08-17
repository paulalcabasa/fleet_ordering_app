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
                    <a href="#" v-show="showFilterButton" @click.prevent="filterFWPC" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                        <i class="flaticon2-search-1"></i>
                    </a>
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md">
                        <i class="la la-angle-down"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-2  col-form-label">Date</label>
                            <div class="col-5">
                                <input type="date" class="form-control" name="" v-model="start_date">
                            </div>
                            <div class="col-5">
                                <input type="date" class="form-control" name="" v-model="end_date">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-2  col-form-label"></label>
                            <div class="col-10">
                                <select class="form-control" id="sel_customer" style="width:100%;">
                                    <option value="">Select a customer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-2"></label>
                            <div class="col-10">
                                <label class="kt-checkbox kt-checkbox--solid kt-checkbox--brand">
                                    <input type="checkbox" v-model="uninvoiced_flag" /> Show only uninvoiced orders
                                    <span></span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6"> 
                        <div class="form-group row" style="margin-bottom:1em !important;" v-show="user_type == 33 || user_type == 32">
                            <label class="col-3  col-form-label">Dealer </label>
                            <div class="col-9">
                                <select class="custom-select form-control" style="width:100%;" id="sel_dealer" v-model="selected_dealer" v-select>
                                    <option selected value="">Select a dealer</option>
                                    <option v-for="(row,index) in dealers" :value="row.cust_account_id">
                                        @{{ row.account_name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-3  col-form-label">Status</label>
                            <div class="col-9">
                                <select class="form-control" v-model="fwpc_status" v-select style="width:100%;" id="sel_status" >
                                    <option selected value="">Select status</option>
                                    <option value="4">Approved</option>
                                    <option value="7">Pending</option>
                                </select>
                            </div>
                        </div>
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
                        <th>Body Application</th>
                        <th>WSP</th>
                        <th>SRP</th>
                        <th>Fleet Price</th>
                        <th>Discount</th>
                        <th>Dealer Margin</th>
                        <th>Competitors Brand</th>
                        <th>Competitors Model</th>
                        <th>Competitors Price</th>
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
                        <td>@{{ row.body_application }}</td>
                        <td>@{{ row.wholesale_price }}</td>
                        <td>@{{ row.suggested_retail_price }}</td>
                        <td>@{{ row.fleet_price }}</td>
                        <td>@{{ row.discount }}</td>
                        <td>@{{ row.dealers_margin }}</td>
                        <td>@{{ row.competitor_brand }}</td>
                        <td>@{{ row.competitor_model }}</td>
                        <td>@{{ row.competitors_price }}</td>
                    </tr>
                </tbody>
            </table>  
        </div>
    </div>
</div>
@stop


@push('scripts')
<script>    

    function updateFunction (el, binding) {
        // get options from binding value. 
        // v-select="THIS-IS-THE-BINDING-VALUE"
        let options = binding.value || {};

        // set up select2
        $(el).select2(options).on("select2:select", (e) => {
            // v-model looks for
            //  - an event named "change"
            //  - a value with property path "$event.target.value"
            el.dispatchEvent(new Event('change', { target: e.target }));
        });
    }

    Vue.directive('select', {
        inserted: updateFunction ,
        componentUpdated: updateFunction,
    });

    var table;


    var vm =  new Vue({
        el : "#app",
        data: {
            fwpc_list:         [],
            start_date:        '',
            end_date:          '',
            uninvoiced_flag:   '',
            fwpc_status:       '',
            dealers:           {!! json_encode($dealers) !!},
            user_type:         {!! json_encode($user_type) !!},
            selected_customer: '',
            selected_dealer:   {!! json_encode($customer_id) !!},
            showFilterButton:  false
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
            
            $("#sel_dealer,#sel_status").select2();
            self.supplyFWPC();  

            var portlet = new KTPortlet('kt_portlet_tools_1');

             // Toggle event handlers
            portlet.on('beforeCollapse', function(portlet) {
                self.showFilterButton = false;
            });

            portlet.on('beforeExpand', function(portlet) {
                self.showFilterButton = true;
            });

            $('#sel_customer').select2({
                tokenSeparators: [',', ' '],
                minimumInputLength: 2,
                minimumResultsForSearch: 10,
                allowClear:true,
                placeholder : 'Select a customer',
                ajax: {
                    url: "{{ url('get-customers-select2')}}",
                    dataType: "json",
                    type: "GET",
                    data: function (params) {

                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.customer_name,
                                    id: item.customer_id
                                }
                            })
                        };
                    }
                }
            });


  
        },
        methods : {
            supplyFWPC(){
                var self = this;
                var customer_id = $("#sel_customer").val();
                
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                // supply fwpc table
                axios.get('get-all-fwpc', {
                    params : {
                        start_date:      self.start_date,
                        end_date:        self.end_date,
                        uninvoiced_flag: self.uninvoiced_flag,
                        fwpc_status:     self.fwpc_status,
                        customer_id:     customer_id,
                        dealer:          self.selected_dealer,
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

