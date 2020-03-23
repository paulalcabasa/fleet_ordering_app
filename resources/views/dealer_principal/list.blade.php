@extends('_layouts.metronic')

@section('page-title', 'Dealer Principals')

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
                    <th>Dealer</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    
                </tr>
            </thead>
            <tbody>
                 <tr v-for="(row,index) in list">
                    <td>
                        <a href="#" @click.prevent="deleteData(row,index)" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                            <i class="la la-trash"></i>
                        </a>
                        <a href="#" @click.prevent="editData(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md" >
                            <i class="la la-edit"></i>
                        </a>
                    </td>
                    <td>@{{ row.dealer.account_name }}</td>
                    <td>@{{ row.name }}</td>
                    <td>@{{ row.position }}</td>
                    <td>@{{ row.mobile_no }}</td>
                    <td>@{{ row.email_address }}</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Dealer Principal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <div class="form-group">
                    <label>Dealer</label>
                    <select name="" id="" class="form-control" v-model="data.dealer_id">
                        <option v-for="(row,index) in dealers" :value="row.cust_account_id">@{{ row.account_name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" v-model="data.name"/>
                </div>
                <div class="form-group">
                    <label>Position</label>
                    <input type="text" class="form-control" v-model="data.position"/>
                </div>
                <div class="form-group">
                    <label>Mobile No.</label>
                    <input type="text" class="form-control" v-model="data.mobile_no"/>
                </div>
                    <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" class="form-control" v-model="data.email_address"/>
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
                principal_id : '',
                name : '',
                position : '',
                mobile_no : '',
                email_address : '',
                dealer_id : ''
            },
            dealers      : {!! json_encode($dealers) !!},
            status_colors: {!! json_encode($status_colors) !!},
            base_url     : {!! json_encode($base_url) !!},
            list         : {!! json_encode($list)!!}
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
                    if(self.data.dealer_id == ""){
                        errors.push('Dealer is required.');                    
                    }
                    if(self.data.name == ""){
                        errors.push('Name is required.');                    
                    }
                    if(self.data.position == ""){
                        errors.push('Position is required.');                    
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

                    axios.post('dealer-principal/add', self.data)
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.list = response.data.principals;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully added dealer principal',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                $("#newModal").modal('hide');
                                self.data = {
                                    principal_id : '',
                                    name : '',
                                    position : '',
                                    contact_no : '',
                                    email : '',
                                    dealer_id : ''
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
                    axios.patch('dealer-principal/update', self.data)
                    .then( (response) => {
                        if($.fn.dataTable.isDataTable('#data')){
                            table.destroy();
                        }
                        self.list = response.data.principals;
                        Swal.fire({
                            type: 'success',
                            title: 'Successfully updated information!',
                            showConfirmButton: true,
                            timer: 1500,
                            onClose : function(data){
                                $("#newModal").modal('hide');
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
                    principal_id : row.principal_id,
                    name         : row.name,
                    position     : row.position,
                    mobile_no    : row.mobile_no,
                    email_address: row.email_address,
                    dealer_id    : row.dealer_id
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
                        axios.delete('dealer-principal/delete/' + row.principal_id)
                            .then( (res) => {
                                self.list.splice(index,1);
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