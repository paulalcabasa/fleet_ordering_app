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
                        <th>Actions</th>
                        <th>Project No.</th>
                        <th>Account Name</th>
                        <th>Dealer</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>FPC</th>
                        <th>PO</th>
                        <th>FWPC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in projects">
                        <td nowrap>
                            <a :href="base_url + '/project-overview/view/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                              <i class="la la-eye"></i>
                            </a>
                            <a v-show="row.status_name == 'Rejected' || row.status_name == 'Draft'" :href="base_url + '/manage-project/edit/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                              <i class="la la-edit"></i>
                            </a>
                        </td>
                        <td>@{{ row.project_id }}</td>
                        <td nowrap>@{{ row.customer_name }}</td>
                        <td>@{{ row.account_name }}</td>
                        <td nowrap @click.prevent="showApproval(row)" style="cursor:pointer;">
                            <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                        </td>
                        <td>@{{ row.date_created }}</td>
                        <td><i class="fa fa-check kt-font-success" v-if="row.fpc_status == 'good'"></i></td>
                        <td><i class="fa fa-check kt-font-success" v-if="row.po_status == 'good'"></i></td>
                        <td><i class="fa fa-check kt-font-success" v-if="row.fwpc_status == 'good'"></i></td>
                     
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
            searchFlag : false
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
         
            
            search(){
                var self = this;
                var customer_id = $("#sel_customer").val();
                
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
                        responsive:true
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