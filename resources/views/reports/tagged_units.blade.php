@extends('_layouts.metronic')

@section('page-title', 'Tagged Units')

@section('content')


<div id="app">
    <div class="kt-portlet kt-portlet--mobile">        
        <div class="kt-portlet__body">
            <table id="data" class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th>Dealer</th>
                        <th>CS No.</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Reservation Date</th>
                        <th>Fleet Account</th>
                        <th>Aging</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in taggedUnits">
                        <td>@{{ row.account_name }}</td>
                        <td>@{{ row.serial_number }}</td>
                        <td>@{{ row.sales_model }}</td>
                        <td>@{{ row.color }}</td>
                        <td>@{{ row.reservation_date }}</td>
                        <td>@{{ row.fleet_account }}</td>
                        <td>@{{ row.aging }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop


@push('scripts')
<script>

   

    var vm =  new Vue({
        el : "#app",
        data: {
            taggedUnits : {!! json_encode($taggedUnits)!!}
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        methods : {
          
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
                initComplete: function (settings, json) {  
                    $("#data").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
                }
            });
        }
    });
</script>
@endpush