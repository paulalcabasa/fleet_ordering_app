@extends('_layouts.metronic')

@section('page-title', 'Purchase Order')

@section('content')

<div class="kt-portlet kt-portlet--mobile" id="app">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                PO List
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
		        
    </div>
</div>

@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {
            
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
          
        }
    });
</script>
@endpush