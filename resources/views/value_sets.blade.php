@extends('_layouts.metronic')

@section('page-title', 'Value Sets')

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
            <a href="#" @click.prevent="newData" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="data" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Category</th>
                    <th>Name</th> 
                </tr>
            </thead>
            <tbody>
                 <tr v-for="(row,index) in value_sets">
                    <td>
                        <a href="#" @click.prevent="deleteData(row,index)" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                            <i class="la la-trash"></i>
                        </a>
                        <a href="#" @click.prevent="editData(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                            <i class="la la-edit"></i>
                        </a>
                    </td>
                    <td>@{{ row.category.name }}</td>
                    <td>@{{ row.description }}</td>
                 </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form class="form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Value Set</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <div class="form-group">
                    <label>Category</label>
                    <select name="" id="" class="form-control" v-model="data.category_id">
                        <option v-for="(row,index) in categories" :value="row.category_id">@{{ row.name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" v-model="data.description"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="saveChanges">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </form>
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
            action       : '',
            data : {
                value_set_id : '',
                category_id : '',
                description : '',
            },
            categories      : {!! json_encode($categories) !!},
            value_sets      : {!! json_encode($value_sets) !!},
            base_url        : {!! json_encode($base_url) !!}
        },
        methods :{
            newData(){
                this.action = "add";
                $("#newModal").modal('show');
            },
            saveChanges(){
                var self = this;
                var errors = [];
        
                if(self.action == "add"){
                    if(self.data.category_id == ""){
                        errors.push('Dealer is required.');                    
                    }
                    if(self.data.description == ""){
                        errors.push('Description is required.');                    
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
                
                if(self.action == "add") {

                    axios.post('value-set/add', self.data)
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.value_sets = response.data.value_sets;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully added value set',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                //$("#newModal").modal('hide');
                                self.data = {
                                    category_id : '',
                                    description : '',
                                };   
                            }
                        });
                    })
                    .then( () => {
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
                    })
                    .catch( (error) => {
                        Swal.fire({
                            type: 'error',
                            title: 'Error : ' + error,
                            showConfirmButton: true,
                            timer: 1500
                        });
                    })
                    .finally( (response) => {

                    });
                
                }
                else {
                    axios.patch('value-set/update', self.data)
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.value_sets = response.data.value_sets;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully updated information!',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                
                            }
                        });
                    })
                    .then( () => {
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
                    })
                    .catch( (error) => {
                        Swal.fire({
                            type: 'error',
                            title: 'Error : ' + error,
                            showConfirmButton: true,
                            timer: 1500
                        });
                    })
                    .finally( (response) => {

                    });
                }
            },
            editData(row){
                this.action    = "edit";
                this.data = {
                    value_set_id: row.value_set_id,
                    category_id : row.category_id,
                    description : row.description
                };
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
            deleteData(row,index){
                var self = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('value-set/delete/' + row.value_set_id)
                            .then( (res) => {
                                self.value_sets.splice(index,1);
                                Swal.fire({
                                    type: 'error',
                                    title: 'Value set has been deleted.',
                                    showConfirmButton: true,
                                    timer: 1500,
                                    onClose : function(data){
                                        
                                    }
                                });
                                /* if($.fn.dataTable.isDataTable('#data')){
                                    table.destroy();
                                }
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
                                }); */
                            })
                            .catch( (err) => {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error : ' + err,
                                    showConfirmButton: true,
                                    timer: 1500
                                });
                            });
                    }
                });   
            }
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
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
        },

        filters : {
            formatDate(value){
                return moment(String(value)).format('MM/DD/YYYY hh:mm');
            }
        }
        
    });
</script>
@endpush