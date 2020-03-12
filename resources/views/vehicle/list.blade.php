@extends('_layouts.metronic')

@section('page-title', 'Isuzu Vehicle Models')

@section('content')
<div id="app">

<div class="kt-portlet kt-portlet--mobile">
  
    <div class="kt-portlet__body">

        <table id="data" class="table table-striped" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Prod Model</th>
                    <th>Sales Model</th>
                    <th>Color</th>
                    
                </tr>
            </thead>
            <tbody>
                    <tr v-for="(row,index) in list">
                        <td>
                            <span class="kt-switch kt-switch--sm kt-switch--icon">
                                <label>
                                    <input type="checkbox" @change="updateState(row,index)" v-model="row.status" :checked="status" />
                                    <span></span>
                                </label>
                            </span>
                        </td> 
                        <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td> 
                        <td>@{{ row.vehicle_type }}</td> 
                        <td>@{{ row.model_variant }}</td> 
                        <td>@{{ row.prod_model }}</td> 
                        <td>@{{ row.sales_model }}</td> 
                        <td>@{{ row.color }}</td> 
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
            action       : '',
            status       : '',
            term_id      : '',
            term_name    : '',
            status_colors: {!! json_encode($status_colors) !!},
            list        : {!! json_encode($list) !!},
            base_url     : {!! json_encode($base_url) !!}
        },
        methods :{
            updateState(row,index){
                var self = this;
                var selIndex = index;
                if(row.status){
                   axios.delete('vehicle/delete-inactive/' + row.id)
                   .then( (response) => {
                        self.list[selIndex].status_name = 'active';
                        self.toast('success',self.list[selIndex].sales_model + " - " + self.list[selIndex].color + " has been activated.");
                   })
                   .catch( (error) => {
                       alert("Error occured : " + error);
                   })
                   .finally( () => {

                   });
                }
                else {
                    axios.post('vehicle/add-inactive',{
                        inventory_item_id : row.inventory_item_id
                    })
                    .then( (response) => {
                        self.list[selIndex].status_name = 'inactive';
                        self.toast('warning',self.list[selIndex].sales_model + " - " + self.list[selIndex].color + " has been deactivated.");

                    })
                    .catch( (error) => {
                        alert("Error occured : " + error);
                    })
                    .finally( () => {
                        
                    });
                }
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