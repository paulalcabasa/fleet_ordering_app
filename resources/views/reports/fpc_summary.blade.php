@extends('_layouts.metronic')

@section('page-title', 'FPC Summary')

@section('content')


<div id="app">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('reports.export_fpc_summary') }}" method="POST" accept-charset="UTF-8">
             <div class="kt-portlet" data-ktportlet="true">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Filters
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-portlet__content">
                        <div class="form-group row" style="margin-bottom:1em !important;">
                            <label class="col-2  col-form-label">Date</label>
                            <div class="col-5">
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-5">
                                <input type="date" class="form-control" name="end_date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                     <div class="row">
                        <div class="col-lg-12 kt-align-right">
                            <button type="submit" class="btn btn-brand" >Submit</button>
                        </div>
                    </div>
                </div>
            </div> 
            </form>
        </div>
        <div class="col-md-6"></div>
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
        methods : {
          
        },
        mounted : function () {

        }
    });
</script>
@endpush