@extends('_layouts.metronic')

@section('page-title', 'Payment Terms')

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
            <a href="#" @click.prevent="newTerm" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New Term</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="data" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    
                </tr>
            </thead>
            <tbody>
                    <tr v-for="(row,index) in terms">
                        <td>
                             <a href="#"  title="Show details"  @click="editData(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a> 
                        </td>
                        <td>@{{ row.term_name }}</td> 
                    </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment Term</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <form class="form">
                    <div class="form-group">
                        <label>Name</label>
                        <textarea class="form-control" v-model='term_name'></textarea>
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
    var table;
    
    var vm =  new Vue({
        el : "#app",
        data: {
            action       : '',
            status       : '',
            term_id      : '',
            term_name    : '',
            status_colors: {!! json_encode($status_colors) !!},
            terms        : {!! json_encode($terms) !!},
            base_url     : {!! json_encode($base_url) !!}
        },
        methods :{
            newTerm(){
                this.action = "add";
                $("#newModal").modal('show');
            },
            addPriceList(){
                var self = this;
                var errors = [];
        
                if(self.action == "add"){
                    if(self.term_name == ""){
                        errors.push('Term name field is required');                    
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
                if(self.action == "add"){
                    axios.post('term/add',{
                        term_name : self.term_name
                    })
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.terms = response.data;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully added payment term!',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                $("#newModal").modal('hide');
                                self.term_name = '';
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
                    axios.patch('term/update',{
                        term_id  : self.term_id,
                        term_name: self.term_name,
                        status   : self.status
                    })
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.terms = response.data;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully updated payment term!',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                $("#newModal").modal('hide');
                                self.term_name = '';
                                self.term_id = '';
                                self.status = '';
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
                this.term_id   = row.term_id;
                this.term_name = row.term_name;
                this.status    = row.status == 1 ? true : false;
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