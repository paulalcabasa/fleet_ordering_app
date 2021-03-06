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
                   <a href="#" v-show="showFilterButton" @click.prevent="filterFPC" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                        <i class="flaticon2-search-1"></i>
                    </a>
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
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
                                <select class="form-control" style="width:100%;" v-select id="sel_status" v-model="fpc_status">
                                    <option selected value="">Select status</option>
                                    <option value="7">Pending</option>
                                    <option value="4">Approved</option>
                                    <option value="5">Rejected</option>
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
                    FPC
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
                            <a :href="base_url + '/price-confirmation-details/' + row.fpc_id"  title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                <i class="la la-eye"></i>
                            </a> 
                        </td>
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
            fpcList:           [],
            base_url:          {!! json_encode($base_url) !!},
            dealers:           {!! json_encode($dealers) !!},
            user_type:         {!! json_encode($user_type) !!},
            start_date:        '',
            end_date:          '',
            fpc_status:        '',
            showFilterButton:  false,
            selected_customer: '',
            selected_dealer:   {!! json_encode($customer_id) !!},
            status_colors:     {!! json_encode($status_colors) !!}
        },
        created: function () {
            // `this` points to the vm instance
        },
        methods : {
            supplyFPC(){
                var self = this;
                var customer_id = $("#sel_customer").val();
                
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.get('get-filtered-fpc',{
                    params : {
                         customer_id: customer_id,
                         start_date:  self.start_date,
                         end_date:    self.end_date,
                         dealer:      self.selected_dealer,
                         status:      self.fpc_status
                    }
                }).then( (response) => {
                    if($.fn.dataTable.isDataTable('#price_confirmation_table')){
                        table.destroy();
                    }
                    self.fpcList = response.data;
                }).then( (response) => {
                    table = $("#price_confirmation_table").DataTable({
                        // Pagination settings
                        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                        buttons: [
                            'print',
                            'copyHtml5',
                            'excelHtml5'
                        ],
                        responsive:true
                    });
                }).finally( (response) => {
                    KTApp.unblockPage();
                });
            },
            filterFPC(){
                this.supplyFPC();
            }
        },
        mounted : function () {
            var self = this;
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

            var portlet = new KTPortlet('kt_portlet_tools_1');

             // Toggle event handlers
            portlet.on('beforeCollapse', function(portlet) {
                self.showFilterButton = false;
            });

            portlet.on('beforeExpand', function(portlet) {
                self.showFilterButton = true;
            });

            $("#sel_dealer,#sel_status").select2();

            this.supplyFPC();
        }
    });
</script>
@endpush