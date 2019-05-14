@extends('_layouts.metronic')

@section('page-title', 'Dashboard')
  
@section('content')
    <p>test content</p>
    <pre>
    {{ print_r(session('user')) }}

    {{ session('user')['user_type_name'] }}

    {{ request()->is('dashboard') }}
@stop

@push('vuejs')
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