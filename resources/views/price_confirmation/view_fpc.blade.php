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
            <a href="#" class="btn btn-secondary btn-sm">
                <span class="kt-hidden-mobile"><i class="fa fa-print"></i></span>
            </a>
         
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

            <div class="col-md-4">
             <!--    <div class="details-item">
                    <span class="details-label">Po No.</span>
                    <span class="details-subtext">
                        <span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill">Pending PO</span>
                    </span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date Submitted</span>
                    <span class="details-subtext">
                        <span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill">Pending PO</span>
                    </span>
                </div> -->
                
            </div> 
        </div>
    </div>
</div>


<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Price
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
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
                    <td>P 937,000.00</td>
                    <td>N/A</td>
                    <td>Complete w/ (3yrs.) LTO Registration</td>
                </tr>
                <tr>
                    <td colspan="7">*****<i class="kt-margin-r-10 kt-margin-l-10">Nothing Follows</i>*****</td>
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
        <!-- <div class="kt-wizard-v1__form">
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
        </div> -->
  
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

         <!--    <div class="details-item">
                <span class="details-label">Availability</span>
                <span class="details-subtext">Within 1 to 3 months upon receipt of purchase order and any necesarry downpayment.</span>
            </div>
            <div class="details-item">
                <span class="details-label">Validity</span>
                <span class="details-subtext">April 15, 2019</span>
            </div>  
            </div>
            <div class="col-md-6">
                  <div class="details-item">
                <span class="details-label">Payment</span>
                <span class="details-subtext">Strictly C.O.D. only</span>
            </div> 
            <div class="details-item">
                <span class="details-label">Dealer Net Commision</span>
                <span class="details-subtext">Please refer to fleet guidelines.</span>
            </div> 
            </div>
        </div> -->
            
           
         
    
  
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