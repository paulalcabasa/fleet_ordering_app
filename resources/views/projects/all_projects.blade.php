@extends('_layouts.metronic')

@section('page-title', 'Fleet Projects')

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
                   <a href="#" v-show="showFilterButton" @click.prevent="filterProjects" class="btn btn-clean btn-sm btn-icon btn-icon-md">
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
                                <select class="custom-select form-control" id="sel_dealer" v-model="selected_dealer" v-select>
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
                                <select class="form-control" v-select id="sel_status" v-model="project_status">
                                    <option selected value="">Select status</option>
                                    <option value="3">New</option>
                                    <option value="11">Open</option>
                                    <option value="6">Cancelled</option>
                                    <option value="5">Rejected</option>
                                    <option value="13">Closed</option>
                                </select>
                            </div>
                        </div>

                     <!--    <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-3  col-form-label">Created by</label>
                            <div class="col-9">
                                <select class="form-control" v-select id="sel_status" v-model="project_status">
                                    <option selected value="">Select status</option>
                                    <option value="3">New</option>
                                    <option value="11">Open</option>
                                    <option value="6">Cancelled</option>
                                    <option value="5">Rejected</option>
                                    <option value="13">Closed</option>
                                </select>
                            </div>
                        </div> -->

                        <!-- <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-3"></label>
                            <div class="col-9">
                                <div class="kt-checkbox-inline">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" v-model="fpc_flag"/>  FPC
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input type="checkbox" v-model="po_flag"/>  PO
                                        <span></span>
                                    </label>
                                    <label class="kt-checkbox">
                                        <input type="checkbox" v-model="fwpc_flag" />  FWPC
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>  
    </div>  

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    All Projects
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-bordered table-hover" style="font-size:90%;" width="100%" id="projects_table">
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
                            <a v-show="(row.status_name == 'Rejected' || row.status_name == 'Draft' || row.status_name == 'Cancelled') && (user_type == 27 || user_type == 31)" :href="base_url + '/manage-project/edit/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                              <i class="la la-edit"></i>
                            </a> 
                            <a v-show="user_type == 32 || user_type == 33" :href="base_url + '/manage-project/edit/' + row.project_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
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

        <div class="modal fade" id="modal_approver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approval Workflow</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Approver</th>
                                    <th>Status</th>
                                    <th>Date Approved</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in cur_approval">
                                    <td>@{{ row.approver_name }}</td>
                                    <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
                                    <td>@{{ row.date_approved }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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
            projects:          [],
            base_url:          {!! json_encode($base_url) !!},
            status_colors:     {!! json_encode($status_colors) !!},
            dealers:           {!! json_encode($dealers) !!},
            user_type:           {!! json_encode($user_type) !!},
            dealer_satellite_id:           {!! json_encode($dealer_satellite_id) !!},
            cur_approval:      [],
            start_date:        '',
            end_date:          '',
            project_status:    '',
            showFilterButton:  false,
            selected_customer: '',
            selected_dealer : {!! json_encode($customer_id) !!},
            fpc_flag : false,
            po_flag : false,
            fwpc_flag : false
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
            viewPriceConfirmation(){
                window.location.href = 'price-confirmation-details/10';
            },
            showApproval(row){

                var self = this;
                axios.get('/ajax-get-approval-workflow/' + row.project_id)
                .then(function(response){
                    self.cur_approval = response.data;
                })
                .catch(function(error){
                    console.log(error);
                })
                .finally(function(){

                });
                $("#modal_approver").modal('show');
            },
            viewProject(project_id){
                window.location.href = this.base_url + '/project-overview/view/' + project_id;
            },
            filterProjects(){
                this.supplyProjects();
            },
            supplyProjects(){
                var self = this;
                var customer_id = $("#sel_customer").val();
                
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.get('ajax-get-filtered-projects',{
                    params : {
                         customer_id        : customer_id,
                         start_date         : self.start_date,
                         end_date           : self.end_date,
                         dealer             : self.selected_dealer,
                         status             : self.project_status,
                         dealer_satellite_id: self.dealer_satellite_id
                    }
                }).then( (response) => {
                    if($.fn.dataTable.isDataTable('#projects_table')){
                        table.destroy();
                    }
                    self.projects = response.data;
                }).then( (response) => {
                    table = $("#projects_table").DataTable({
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

            var self = this;

            this.supplyProjects();

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

      

        }
    });
</script>
@endpush