@extends('_layouts.metronic')

@section('page-title', 'Pricelist')

@section('content')
<div id="app">
     <div class="kt-portlet" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Details
                </h3>
            </div>
            
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="details-item">
                            <span class="details-label">Price List Name</span>
                            <span class="details-subtext">@{{ header_details.name }}</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Description</span>
                            <span class="details-subtext">@{{ header_details.description }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="details-item">
                            <span class="details-label">Created by</span>
                            <span class="details-subtext">@{{ header_details.created_by }}</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Date Created</span>
                            <span class="details-subtext">@{{ header_details.creation_date | formatDate }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="details-item">
                            <span class="details-label">Status</span>
                            <span :class="status_colors[header_details.status_name]">@{{ header_details.status_name }}</span>
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
                    Vehicles
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#" @click.prevent="addNew" class="btn btn-primary btn-sm">
                    <span class="kt-hidden-mobile">Add Vehicle</span>
                </a>
            </div>
        </div>
        <div class="kt-portlet__body">

            <table id="datatable" class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>SRP</th>
                        <th>WSP</th>
                        <th>Promo</th>
                        <th>LTO Registration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                     <tr v-for="(row,index) in pricelist_lines">
                            <td>
                                <a href="#" @click.prevent="updateLine(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
                                <i class="la la-edit"></i>
                                </a>
                            </td>
                            <td>@{{ row.sales_model }}</td>
                            <td>@{{ row.color }}</td>
                            <td>@{{ formatPrice(row.srp) }}</td>
                            <td>@{{ formatPrice(row.wsp) }}</td>
                            <td>@{{ formatPrice(row.promo) }}</td>
                            <td>@{{ formatPrice(row.lto_registration) }}</td>    
                            <td>
                                <span :class="status_colors[row.status_name]">@{{ row.status_name }}</span>
                            </td>    
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vehicle Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">  
                    <form class="form">
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label">Model</label>
                            <div class="col-lg-8">
                                <span v-show="action == 'add'">
                                    <select  class="form-control" id="sel_vehicle_models" v-model="selected_model" v-select style="width:100%;">
                                        <option value="-1">Select a model</option>
                                        <optgroup v-for="(row,index) in  vehicle_models" :label="row.model">
                                            <option 
                                                v-for="(variant,index) in row.variants" 
                                                :value="variant.id" 
                                                :data-vehicle_type="variant.vehicle_type"
                                                :data-variant="variant.variant"
                                            >@{{ variant.value}}</option>
                                        </optgroup>
                                    </select>   
                                </span>
                                <input v-show="action == 'edit'" type="text" class="form-control"  readonly="readonly" :value="curModel.sales_model"/>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label">Color</label>
                            <div class="col-lg-8">
                                <span v-show="action == 'add'" >
                                    <select class="form-control" id="sel_vehicle_colors" v-model="selected_color" v-select style="width:100%;">
                                        <option value="-1">Select a color</option>
                                        <option v-for="(row,index) in vehicleColors" :value="row">@{{ row.color }}</option>
                                    </select>
                                </span>
                                <input v-show="action == 'edit'" type="text" class="form-control"  readonly="readonly" :value="curModel.color"/>
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label">SRP</label>
                            <div class="col-lg-8">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model.lazy="curModel.srp"
                                    v-mask="{alias:'currency',prefix: ' ', greedy: true }"
                                />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label"><abbr title=" (Oracle WSP * 1.12)">WSP</abbr></label>
                            <div class="col-lg-8">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model.lazy="curModel.wsp"
                                    v-mask="{alias:'currency',prefix: ' ', greedy: true }"
                                    
                                />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label"><abbr title="Default value from Floor Subsidy of Sales Promo Monitoring">Promo</abbr></label>
                            <div class="col-lg-8">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model.lazy="curModel.promo"
                                    v-mask="{alias:'currency',prefix: ' ', greedy: true }"
                                />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;">
                            <label class="col-lg-4 col-form-label">LTO Registration</label>
                            <div class="col-lg-8">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model.lazy="curModel.lto_registration"
                                    v-mask="{alias:'currency',prefix: ' ', greedy: true }"
                                />
                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom:.5em !important;" v-if="action == 'edit'">
                            <label class="col-lg-4 col-form-label">Status</label>
                            <div class="col-lg-8">
                                <span class="kt-switch kt-switch--sm kt-switch--icon">
                                    <label>
                                        <input type="checkbox" v-model="curModel.status_flag" :checked="curModel.status_flag" />
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="saveVehicle">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            header_details : {!! json_encode($header_data) !!},
            status_colors : {!! json_encode($status_colors) !!},
            curModel : {
                wsp              : 0,
                srp              : 0,
                inventory_item_id: '',
                lto_registration : 0,
                promo            : 0,
                status           : 1,
                pricelist_line_id: 0,
                sales_model      : '',
                color            : '',
                status_flag      : false
            },
            vehicle_models: {!! json_encode($vehicle_models) !!},
            selected_model: -1,
            vehicleColors : [],
            selected_color: -1,
            pricelist_lines: [],
            action: ''
        },
        methods :{
            toast(type,message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                });

                Toast.fire({
                    type: type,
                    title: message
                });
            },
            addNew(){
                var self = this;
                self.action = "add";
                self.curModel.wsp               = 0;
                self.curModel.srp               = 0;
                self.curModel.inventory_item_id = 0;
                self.curModel.lto_registration  = 0;
                self.curModel.promo             = 0;
                self.selected_model             = -1;
                self.selected_color             = -1;
                self.curModel.status            = 1;
                self.curModel.pricelist_line_id = 0;
                $("#newModal").modal('show');
            },
            saveVehicle(){
                var self = this;
                var errors = [];
                
                if(self.action == "add"){
                    if(self.selected_model == -1){
                        errors.push('Select a model');                    
                    }

                    if(self.selected_color == -1){
                        errors.push('Select a color');
                    }
                }

                if(errors.length > 0){
                    var message = "<ul>";
                    for(var msg of errors){
                        message += "<li>" + msg + "</li>";
                    }
                    message += "<ul>";
                    Swal.fire({
                        type: 'error',
                        title: message,
                        showConfirmButton: true
                    });
                    return false;
                }

                KTApp.block("#newModal .modal-content",{});
                axios.post('add-vehicle-price',{
                    vehicle : self.curModel,
                    pricelist_header_id : self.header_details.pricelist_header_id,
                    action:self.action
                })
                .then( (response) => {

                    if(response.data.status == 500){
                        Swal.fire({
                            type: 'error',
                            title: response.data.msg,
                            showConfirmButton: true,
                            timer: 1500
                        });

                        return false;

                    }
                    Swal.fire({
                        type: 'success',
                        title: response.data.msg,
                        showConfirmButton: true,
                        timer: 1500
                    });
                    $("#newModal").modal('hide')
                    this.getPriceListLines();
                })
                .catch( (error) => {
                    Swal.fire({
                        type: 'error',
                        title: 'Unexpected error occurred, could not add this model. Error : ' + error,
                        showConfirmButton: true,
                        timer: 1500
                    });
                })
                .finally( (response) => {
                    KTApp.unblock("#newModal .modal-content",{});
                });
            },
            getPriceListLines(){
                var self = this;

                 KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });

                axios.get('get-pricelist-lines/' + this.header_details.pricelist_header_id)
                .then( (response) => {
                    if($.fn.dataTable.isDataTable('#datatable')){
                        table.destroy();
                    }    
                    self.pricelist_lines = response.data;
                })
                .then( (response) => {
                    table = $("#datatable").DataTable({
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
                })
                .catch( (response) => {
                    console.log(response);
                    Swal.fire({
                        type: 'error',
                        title: 'Unexpected error occurred, Please reload the page to continue.',
                        showConfirmButton: true,
                        timer: 1500
                    });
                })
                .finally( (response) => {
                    KTApp.unblockPage();
                });
            },
            updateLine(row){
                var self = this;
                self.action = "edit";
                self.curModel.wsp               = row.wsp;
                self.curModel.srp               = row.srp;
                self.curModel.inventory_item_id = row.inventory_item_id;
                self.curModel.lto_registration  = row.lto_registration;
                self.curModel.promo             = row.promo;
                self.curModel.status            = row.status;
                self.curModel.sales_model       = row.sales_model;
                self.curModel.color             = row.color;
                self.curModel.pricelist_line_id = row.pricelist_line_id;
                self.curModel.status_flag       = self.curModel.status == 1 ? true : false;
                $("#newModal").modal('show');
            },
            formatPrice(value){
                return (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            }
        },
        created: function () {
            // `this` points to the vm instance
             this.getPriceListLines();
        },

        mounted : function () {
            //this.getPriceListLines();
        },

        watch : {
            selected_model : function(val){
                let self = this;
                KTApp.block("#newModal .modal-content",{});
                axios.get('vehicle/color/' + val)
                    .then(function (response) {
                        self.vehicleColors = response.data;
                        $("#sel_vehicle_colors").select2();
                        self.selected_color = -1;
                        KTApp.unblockPage();
                    })
                    .then((response)=>{
                        if(self.action == 'edit'){
                            self.selected_color = self.curModel.inventory_item_id;
                        }
                    })
                    .catch(function (error) {
                        Swal.fire({
                            type: 'error',
                            title: 'Unexpected error occurred, could not add this model. Error : ' + error,
                            showConfirmButton: true,
                            timer: 1500
                        });
                    })
                    .finally(function () {
                        KTApp.unblock("#newModal .modal-content",{});
                    });
            },
            selected_color : function(val){
                this.curModel.inventory_item_id = val.inventory_item_id;
                this.curModel.wsp = parseFloat(val.price) * 1.12;
                this.curModel.promo = val.floor_subsidy
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