@extends('_layouts.metronic')

@section('page-title', 'Pricelist')

@section('content')
<div id="app">

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                List
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="#" @click.prevent="newPriceList" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New Price List</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="datatable" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date created</th>
                    <th>Created by</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                    <tr v-for="(row,index) in headers">
                        <td>
                            <a :href="base_url + '/pricelist-details/' + row.pricelist_header_id" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                                <i class="la la-eye"></i>
                            </a>
                            <a href="#" @click.prevent="editData(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                                <i class="la la-edit"></i>
                            </a>
                        </td>
                        <td>@{{ row.name }}</td>
                        <td>@{{ row.description }}</td>
                        <td>@{{ row.creation_date | formatDate }}</td>
                        <td>@{{ row.created_by }}</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Pricelist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <form class="form">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" v-if="action == 'add'" class="form-control" v-model='pricelist_name' />
                        <input type="text" v-if="action == 'edit'" readonly="readonly" class="form-control" :value="pricelist_name" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model='description'></textarea>
                    </div>
                    <div class="form-group" v-if="action == 'edit'">
                        <label class="col-form-label">Status</label>
                        <div>
                            <span class="kt-switch kt-switch--sm kt-switch--icon">
                                <label>
                                    <input type="checkbox" v-model="status" :checked="status" />
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="addPriceList">Save</button>
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

    var vm =  new Vue({
        el : "#app",
        data: {
            pricelist_name: '',
            description   : '',
            status        : '',
            action        : '',
            pricelist_header_id : '',
            headers       : {!! json_encode($headers) !!},
            status_colors : {!! json_encode($status_colors) !!},
            base_url      : {!! json_encode($base_url) !!}
        },
        methods :{
            newPriceList(){
                this.action = "add";
                this.pricelist_name = "";
                this.description = "";
                this.description = "";
                $("#newModal").modal('show');
            },
            addPriceList(){
                var self = this;
                var errors = [];
                if(self.action == "add"){
                    if(self.pricelist_name == ""){
                        errors.push('Kindly enter the pricelist name.');                    
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


                axios.post('add-pricelist',{
                    pricelist_name : self.pricelist_name,
                    description : self.description,
                    status : self.status,
                    action : self.action,
                    pricelist_header_id : self.pricelist_header_id
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

                    if(self.action == "add"){
                        var msg = response.data.msg;
                        var pricelist_header_id = response.data.pricelist_header_id;
                        Swal.fire({
                            type: 'success',
                            title: msg,
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                window.location.href = self.base_url + "/pricelist-details/" + pricelist_header_id;
                            }
                        });
                    }

                    else if(self.action == "edit"){
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully updated pricelist!',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                window.location.reload();
                            }
                        });
                    }
                })
                .catch( (error) => {

                })
                .finally( (response) => {

                });
            },
            editData(row){
                this.action              = "edit";
                this.pricelist_header_id = row.pricelist_header_id;
                this.pricelist_name      = row.name;
                this.description         = row.description;
                this.status              = row.status == 1 ? true : false;
                $("#newModal").modal('show');
            },
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
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
            var table = $("#datatable").DataTable({
                responsive:true
            });
        },

        filters : {
            formatDate(value){
                return moment(String(value)).format('MM/DD/YYYY hh:mm');
            }
        }
        
    });
</script>
@endpush