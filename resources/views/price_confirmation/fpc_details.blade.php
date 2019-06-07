@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--mobile" >
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Price Confirmation
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            @if($action == "validate")
            <a href="#"class="btn btn-success kt-margin-r-5"  @click="approveFPC()">
                <span class="kt-hidden-mobile">Approve</span>
            </a>
            <a href="#"class="btn btn-danger" @click="rejectFPC()">
                <span class="kt-hidden-mobile">Reject</span>
            </a>
            @endif
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Price Confirmation Reference</span>
                    <span class="details-subtext">FPC{{ $fpc_id }}</span>
                </div> 
                <div class="details-item">
                    <span class="details-label">Account Name</span>
                    <span class="details-subtext">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Dealer</span>
                    <span class="details-subtext">
                        <ul style="list-style:none;padding:0">
                            <li>Isuzu Pasig</li>
                            <li>Isuzu Commonwealth</li>
                        </ul>
                    </span>
                </div>
            </div>
            <div class="col-md-4">
                
                <div class="details-item">
                    <span class="details-label">Date Confirmed</span>
                    <span class="details-subtext">May 20, 2019</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Confirmed By</span>
                    <span class="details-subtext">John Doe</span>
                </div>
            </div>           
        </div>
    </div>
</div>



<div class="kt-portlet kt-portlet--height-fluid" v-for="(row,index) in dealers">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @{{ row.dealer_name }}
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" :href="'#orders_tab_' + index" role="tab" aria-selected="true">
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" :href="'#competitors_tab_' + index" role="tab" aria-selected="false">
                        Terms
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" :id="'orders_tab_' + index">
                  <table class="table table-bordered table-condensed text-center">
                    <thead>
                        <tr>
                            <td rowspan="2"></td>
                            <td rowspan="2">MODEL</td>
                            <td rowspan="2">QTY</td>
                            <td rowspan="2">TYPE OF BODY</td>
                            <td rowspan="2">UNIT PRICE</td>
                            <td colspan="2">INCLUSION</td>
                        </tr>
                        <tr>
                            <td>STD</td>
                            <td>ADD'L</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>D-Max 4x2 LT MT (RZ4E) Euro 4</td>
                            <td>6</td>
                            <td>N/A</td>
                            <td><a href="#" data-toggle="modal" data-target="#priceDrillDownModal">P 937,000.00</a></td>
                            <td>N/A</td>
                            <td>Complete w/ (3yrs.) LTO Registration</td>
                        </tr>
                        <tr>
                            <td colspan="7">*****<i class="kt-margin-r-10 kt-margin-l-10">Nothing Follows</i>*****</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" :id="'competitors_tab_'+ index">
                <div class="row">
                    <div class="col-md-2">
                        <span class="details-label">Note</span>
                    </div>
                    <div class="col-md-9">
                           <span class="details-subtext">: All participating dealers shall use the same "Fleet price and inclusions". Violators shall be dealt with accordingly.</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <span class="details-label">Availability</span>
                    </div>
                    <div class="col-md-9">
                           <span class="details-subtext">: Within 1 to 3 months upon receipt of purchase order and any necesarry downpayment.</span>
                    </div>
                </div>
         
                <div class="row">
                    <div class="col-md-2">
                        <span class="details-label">Validity</span>
                    </div>
                    <div class="col-md-9">
                           <span class="details-subtext">: April 15, 2019</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <span class="details-label">Payment</span>
                    </div>
                    <div class="col-md-9">
                           <span class="details-subtext">: Strictly C.O.D. only</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <span class="details-label">Dealer Net Commision</span>
                    </div>
                    <div class="col-md-9">
                           <span class="details-subtext">: Please refer to fleet guidelines.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="priceDrillDownModal" style="z-index:1131" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="true">Order Detail</a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-addtl" role="tab" aria-controls="nav-addtl" aria-selected="false">Additional Detail</a> 
                        <a class="nav-item nav-link" data-toggle="tab" href="#nav-delivery-sched" role="tab" aria-controls="nav-delivery-sched" aria-selected="false">Delivery Schedule</a> 
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-orders" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="details-item">
                                            <span class="details-label">Order Control No.</span>
                                            <span class="details-subtext">001</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Account Name</span>
                                            <span class="details-subtext">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Dealer</span>
                                            <span class="details-subtext">PASIG</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Date</span>
                                            <span class="details-subtext">April 1, 2019</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">QKR77 (CAB-LESS 80A)</span>
                                        </div>

                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">2</span>
                                        </div>
                                    </div>
                                </div>
                 
                            </div>
                            <div class="col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">One Price</span>
                                                    <span class="col-md-8 kt-font-boldest kt-font-primary">1,570,00.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Wholesale Price</span>
                                                    <span class="col-md-8 kt-font-boldest kt-font-primary">1,475,000.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Dealer's Margin</span>
                                                    <span class="col-md-8">92,400.00 (6%)</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">3 Yrs LTO Registration</span>
                                                    <span class="col-md-8">10,500.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Freebies</span>
                                                    <span class="col-md-8">0.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Cost</span>
                                                    <span class="col-md-8 kt-font-bold kt-font-danger">1,578,700.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Promo Title</span>
                                                    <span class="col-md-8"></span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Promo</span>
                                                    <span class="col-md-8">0.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Net Cost</span>
                                                    <span class="col-md-8 kt-font-bold kt-font-primary">1,578,700.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Fleet Price</span>
                                                    <span class="col-md-8 kt-font-boldest kt-font-primary">1,540,000.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Subsidy</span>
                                                    <span class="col-md-8">38,700.00</span>
                                                </div>
                                                <div class="row kt-margin-b-5">
                                                    <span class="col-md-4 kt-font-bold">Total IPC Subsidy</span>
                                                    <span class="col-md-8">38,700.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                             <!--    <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Descrition</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>One Price</td>
                                            <td>1,570,00.00</td>
                                        </tr>
                                        <tr>
                                            <td>Wholesale Price</td>
                                            <td>1,475,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>Dealer's Margin</td>
                                            <td>92,400.00 (6%)</td>
                                        </tr>
                                        <tr>
                                            <td>3 Yrs LTO Registration</td>
                                            <td>10,500.00</td>
                                        </tr>
                                        <tr>
                                            <td>Freebies</td>
                                            <td>0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Cost</td>
                                            <td><strong>1,578,700.00</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Promo Title</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Promo</td>
                                            <td>0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Net Cost</td>
                                            <td>1,578,700.00</td>
                                        </tr>
                                        <tr>
                                            <td>Fleet Price</td>
                                            <td>1,540,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>Subsidy</td>
                                            <td>38,700.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total IPC Subsidy</td>
                                            <td><strong>38,700.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table> -->
                            </div>
           
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-addtl" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th style="width:60%;">Description</th>
                                    <th style="width:40%;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Grille</td>
                                    <td>15,000.00</td>
                                </tr>
                                <tr>
                                    <td>Mags</td>
                                    <td>25,000.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>30,000.00</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-delivery-sched" role="tabpanel" aria-labelledby="nav-delivery-sched">
                         <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">D-MAX RZ4E 4x2 Cab/Chassis</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Color</span>
                                            <span class="details-subtext">Red Spinel Mica</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Quantity</td>
                                            <td>Date</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5</td>
                                            <td>June 5, 2019</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>June 10, 2019</td>
                                        </tr>
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <!--  <button type="button" class="btn btn-success">Save changes</button>
                <a href="#" @click.prevent="printPrintConfirmation(project_id)" class="btn btn-primary">Print</a>
                <button type="button" v-if="active_tab == 1" class="btn btn-primary" @click="addRow()">Add row</button> -->
            </div>
        </div>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject FPC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">          
                <div class="form-group">
                    <label>Are you sure to cancel this fpc? Kindly state your reason.</label>
                    <textarea class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="confirmReject" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


</div>
@stop


@push('scripts')
<script>

var DatePicker = function(){

    var deliverySchedule = function(){
        $('#txt_delivery_schedule').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    return {
        // public functions
        init: function() {
            deliverySchedule(); 
        }
    };
}();

jQuery(document).ready(function() { 
    DatePicker.init();
});

    var vm =  new Vue({
        el : "#app",
        data: {
            dealers : [
                {
                    dealer_name : "PASIG",
                    orders : [
                        {
                            model : "D-Max 4x2 LT MT (RZ4E) Euro 4",
                            quantity : 4,
                            type_of_body : "WINGVAN",
                            unit_price : "937,000.00.00"
                        }
                    ]
                },
                {
                    dealer_name : "MAKATI",
                    orders : [
                        {
                            model : "D-Max 4x2 LT MT (RZ4E) Euro 4",
                            quantity : 4,
                            type_of_body : "WINGVAN",
                            unit_price : "937,000.00.00"
                        }
                    ]
                },
            ]
        },
        created: function () {
            // `this` points to the vm instance
        },
        methods : {
            priceConfirmation(order){
                $("#priceConfirmationModal").modal('show');
            },
            submitFWPC(){
                Swal.fire({
                    type: 'success',
                    title: 'FWPC has been successfully submitted!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-fwpc') }} ";
                    }
                });
            },
            createFWPC(){
                Swal.fire({
                    type: 'success',
                    title: 'FWPC has been successfully created!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-fwpc') }} ";
                    }
                });
            },
            rejectFPC(){
                $("#rejectModal").modal('show');
            },
            approveFPC(){
                 Swal.fire({
                    type: 'success',
                    title: 'Fleet price confirmation has been approved!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('fpc-approval')}}";
                    }
                })
            },
            confirmReject(){
                Swal.fire({
                    type: 'error',
                    title: 'Project has been rejected.',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('fpc-approval')}}";
                    }
                });
            },
        },
        computed : {
            dealers_margin(){
                return this.one_price * (this.dealers_margin_percent/100) ;
            },
            cost(){
                return this.wholesale_price + this.dealers_margin + this.lto_registration;
            },
            net_cost(){
                return (this.wholesale_price + this.dealers_margin + this.lto_registration) - this.promo;
            },
            subsidy(){
                return this.net_cost - this.fleet_price;
            }
        },
        mounted : function () {
            
          
        },
        filters: {
            formatPeso: function (value) {
                 return `${value.toLocaleString()}`
            }
        }
    });


   
</script>
@endpush