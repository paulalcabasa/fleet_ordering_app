@extends('_layouts.metronic')

@section('page-title', 'Invoices')

@section('content')

<div id="app">

    <div class="row">
        <div class="col-md-6">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <div class="kt-portlet__content">
                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-2  col-form-label">Date</label>
                            <div class="col-5">
                                <input type="date" class="form-control" name="" v-model="start_date">
                            </div>
                            <div class="col-5">
                                <input type="date" class="form-control" name="" v-model="end_date">
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="kt-portlet__foot">
                    <div class="row  kt-pull-right">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success btn-sm" @click="search">Search</button>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="col-md-6"></div>
    </div>
    <div class="kt-portlet kt-portlet--mobile" v-if="searchFlag">
       
        <div class="kt-portlet__body">
            <table class="table table-bordered table-hover" style="font-size:90%;" width="100%" id="data">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Dealer</th>
                        <th>Fleet Account</th>
                        <th>CS #</th>
                        <th>Sales Model</th>
                        <th>Color</th>
                        <th>Invoice Date</th>
                        <th>Payment Terms</th>
                        <th>Body Application</th>
                        <th>WSP</th>
                        <th>SRP</th>
                        <th>Fleet Price</th>
                        <th>Discount</th>
                        <th>Margin</th>
                        <th>Competitors Brand</th>
                        <th>Competitors Model</th>
                        <th>Competitors Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in invoices">
                      
                        <td>@{{ row.trx_number }}</td>
                        <td>@{{ row.account_name }}</td>
                        <td>@{{ row.fleet_name }}</td>
                        <td>@{{ row.cs_number }}</td>
                        <td>@{{ row.sales_model }}</td>
                        <td>@{{ row.body_color }}</td>
                        <td>@{{ row.trx_date }}</td>
                        <td>@{{ row.payment_terms }}</td>
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
            invoices : [],
            searchFlag : false,
            start_date : '',
            end_date : ''
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
         
            
            search(){
                var self = this;
                
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.get('invoice/get',{
                    params : {
                        start_date:  self.start_date,
                        end_date:    self.end_date,
                    }
                }).then( (response) => {
                    if($.fn.dataTable.isDataTable('#data')){
                        table.destroy();
                    }
                    self.searchFlag = true;
                    self.invoices = response.data;
                }).then( (response) => {
                    table = $("#data").DataTable({
                        // Pagination settings
                        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                        <'row'<'col-sm-12'tr>>
                        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                        buttons: [
                            'print',
                            'copyHtml5',
                            'excelHtml5'
                        ],
                        responsive:false,
                        initComplete: function (settings, json) {  
                            $("#data").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                        }
                    });
                }).finally( (response) => {
                    KTApp.unblockPage();
                });
            }
        },
        mounted : function () {

            

      

        }
    });
</script>
@endpush