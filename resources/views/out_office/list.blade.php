@extends('_layouts.metronic')

@section('page-title', 'Out of Office')

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
            <a href="#" @click="newData"  class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">New</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">

        <table id="data" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in list">
                    <td>@{{ row.approver_name }}</td>
                    <td>@{{ row.start_date | formatDate }}</td>
                    <td>@{{ row.end_date | formatDate }}</td>
                    <td>@{{ row.remarks }}</td>
                    <td>
                        <a href="#" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-edit"></i></a>
                        <a href="#" class="btn btn-danger  btn-sm btn-icon btn-circle"><i class="la la-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <form class="form">
                    <div class="form-group">
                        <label>Name</label>
                        <select class="form-control" v-model="form.approver" id="sel_approver" v-select style="width:100%;">
                            <option value="">Choose user</option>
                            <option :value="approver" v-for="approver in approvers" >@{{ approver.approver_name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" v-model="form.startDate" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" v-model="form.endDate" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" v-model="form.remarks"></textarea>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="save">Save</button>
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
            list: {!! json_encode($list) !!},
            approvers: {!! json_encode($approvers) !!},
            form : {
                approver : '',
                startDate : '',
                endDate : '',
                remarks : ''
            },
            action : ''
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
            newData(){
                this.action = "add";
                $("#form").modal("show");
            },
            save(){

                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });
                
                axios.post('out-of-office/save', {
                    form : this.form
                }).then(res => {
                    if($.fn.dataTable.isDataTable('#data')){
                        table.destroy();
                    }
                    this.list = res.data.list;
                    this.initTable();
                    $("#form").modal("hide");
                    this.toast('success','Data successfully saved.');
                }).catch(err => {
                    console.log(err);
                }).finally( (response) => {
                    KTApp.unblockPage();
                });
            },
            initTable(){
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
            }
            
        },
        created: function () {
            // `this` points to the vm instance
          
        },

        mounted : function () {
            this.initTable();
        },

        filters : {
            formatDate: function(date) {
        		return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        	},
        }
        
    });
</script>
@endpush