@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="kt-portlet kt-portlet--mobile" >
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Prepare FWPC
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">

            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Project Reference No.</span>
                    <span class="details-subtext">PRJ001</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Account Name</span>
                    <span class="details-subtext">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Dealer Name</span>
                    <span class="details-subtext">Isuzu Pasig</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date Submitted</span>
                    <span class="details-subtext">May 19, 2019</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Price Confirmation Reference</span>
                    <span class="details-subtext">FPC{{ $price_confirmation_id }}</span>
                </div>  
                <div class="details-item">
                    <span class="details-label">Date Confirmed</span>
                    <span class="details-subtext">May 20, 2019</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Confirmed By</span>
                    <span class="details-subtext">John Doe</span>
                </div>
            </div>            

            <div class="col-md-4">
                <div class="details-item">
                    <span class="details-label">Po No.</span>
                    <span class="details-subtext">PO001</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date Submitted</span>
                    <span class="details-subtext">May 20, 2019</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Sales Person</span>
                    <span class="details-subtext">
                        <ul>
                            <li>Mr. William Abril</li>
                            <li>Richard Ofrin</li>
                        </ul>
                    </span>
                </div>
            </div> 
        </div>
    </div>
</div>


<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Prices
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-bordered table-condensed" style="font-size:85%;">
            <thead style="text-align:center;">
            
                <tr>
                    <th rowspan="2">Item</th>
                    <th rowspan="2">Model</th>
                    <th rowspan="2">Qty</th>
                    <th rowspan="2">Approved Fleet Price per Unit</th>
                    <th colspan="2">Price Breakdown</th>
                    <th rowspan="2">Fleet Wholesale per unit</th>
                    <th rowspan="2">Total Wholesale Price per Model</th>
                    <th rowspan="2">Payment Term</th>
                </tr>
                <tr>
                    <th>Unit</th>
                    <th>Body, Aircon, Audio & Other Cost</th>
                   
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>D-MAX 4X2 LT MT 1.9L (RZ4E)</td>
                    <td>3</td>
                    <td>937,000.00</td>
                    <td>898,390.00</td>
                    <td></td>
                    <td>898,390.00</td>
                    <td>2,695,170.00</td>
                    <td>C.O.D</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total Fleet Wholesale Price (w / VAT)</th>
                    <th colspan="2">2,695,170.00</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Dealer Margin and Other Cost
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-bordered table-condensed" style="font-size:85%;">
            <thead style="text-align:center;">
                <tr>
                    <th>Item</th>
                    <th>Model</th>
                    <th>Dealer Margin</th>
                    <th>LTO Reg. & Free Items</th>
                    <th>Total Dealer Margin</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>D-MAX 4X2 LT MT 1.9L (RZ4E)</td>
                    <td>28,110.00</td>
                    <td>10,500.00</td>
                    <td>38,610.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Terms and Conditions
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-wizard-v1__form">
           <div class="form-group">
                <label>Payment Term</label>
                <input type="text" class="form-control" value="Strictly start upon pull-out from IPC, as an agreement." readonly="readonly" />
            </div>
            <div class="form-group">
                <label>Witholding Tax</label>
                <input type="text" class="form-control" value="24, 064.02" readonly="readonly" />
            </div>
            <div class="form-group">
                <label>Total Check Payable to IPC</label>
                <input type="text" class="form-control" value="2,671,105.98" readonly="readonly" />
            </div>
            <div class="form-group">
                <label>Delivery schedule</label>
                <input type="text" class="form-control" id="txt_delivery_schedule" placeholder="Delivery schedule"  aria-describedby="fname-error">
                <span class="form-text text-muted">Please enter delivery schedule.</span>
            </div>
        </div>
        
      <!--   <div class="col-md-12">
            <div class="details-item">
                <span class="details-label">Payment Term</span>
                <span class="details-subtext">Strictly start upon pull-out from IPC, as an agreement.</span>
            </div>
            <div class="details-item">
                <span class="details-label">Witholding Tax</span>
                <span class="details-subtext">24, 064.02</span>
            </div>
            <div class="details-item">
                <span class="details-label">Total Check Payable to IPC</span>
                <span class="details-subtext">2,671,105.98</span>
            </div>     
        </div> -->
    </div>
    <div class="kt-portlet__foot ">
        @if($action == 'create')
        <button type="button" class="btn btn-brand kt-pull-right" @click="createFWPC()">Create</button>
        @elseif($action == 'update')
        <button type="button" class="btn btn-brand kt-pull-right" @click="submitFWPC()">Submit</button>
        @elseif($action == 'approve')
        <button type="button" class="btn btn-danger kt-pull-right " >Reject</button>
        <button type="button" class="btn btn-success kt-pull-right kt-margin-r-10" >Approve</button>
        @endif
    </div>
</div>


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
            additional_details : [
                {
                    description : "Grille",
                    amount : 5000
                },
                {
                    description : "Grille 2",
                    amount : 5000
                }
            ],
            projects : [
                {
                    project_id : '001',
                    dealer : 'PASIG',
                    body_builder_name : 'Almazora',
                    rear_body_type : 'Jeepney',
                    orders : [
                        {
                            model : 'QKR77 (CAB-LESS 80A)',
                            color : 'WHITE',
                            ordered_quantity : 50,
                            particulars : '',
                            srp : '1200000'
                        },
                        {
                            model : '185 D-MAX 3.0 4x4 LS MT',
                            color : 'SPLASH WHITE',
                            ordered_quantity : 20,
                            particulars : '',
                            srp : '1200000'
                        }
                    ],
                    competitors: [
                        {
                            brand : 'MITSUBUSHI',
                            model : 'FUSO',
                            price : '1,100,000.00'
                        }
                    ]
                }
            ],
            one_price : 1570000,
            wholesale_price : 1475000,
            dealers_margin_percent : 6,
            lto_registration : 10500,
            freebies : 0,
            promo : 0,
            fleet_price : 1540000
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
            }
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