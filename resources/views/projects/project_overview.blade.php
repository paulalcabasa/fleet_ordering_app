@extends('_layouts.metronic')

@section('page-title', 'Project Overview')

@section('content')

<div id="app"> <!-- start of app wrapper -->

<div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Details
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <ul class="nav nav-pills nav-pills-sm" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#account" role="tab" aria-selected="true">
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#contact" role="tab" aria-selected="false">
                        Contact Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#requirement" role="tab" aria-selected="false">
                        Requirement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#competitors" role="tab" aria-selected="false">
                        Competitors
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#terms" role="tab" aria-selected="false">
                        Terms and Conditions
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="account">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Project No.</span>
                            <span class="col-md-8 kt-font-boldest kt-font-primary">001</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Dealer</span>
                            <span class="col-md-8 kt-font-bold kt-font-primary">Isuzu Automotive Dealership Inc. - Pasig</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Account Name</span>
                            <span class="col-md-8 kt-font-bold kt-font-primary">RCP SENIA TRADING/ RCP SENIA TRANSPORT</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Project Source</span>
                            <span class="col-md-8">Walk In</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Vehicle Type</span>
                            <span class="col-md-8">Light Commercial Vehicle</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Date Submitted</span>
                            <span class="col-md-8">May 21,2019</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Submitted By</span>
                            <span class="col-md-8">John Doe</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Status</span>
                            <span class="col-md-8">
                                <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">Approved</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Organization Type</span>
                            <span class="col-md-8">Private</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">TIN</span>
                            <span class="col-md-8 kt-font-bold kt-font-primary">459-543-12345</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Address</span>
                            <span class="col-md-8">114 Technology Avenue, Phase II Laguna Technopark 4024</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Attachment</span>
                            <span class="col-md-8"><a href="#">File.pdf</a></span>
                        </div>

                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Business Style</span>
                            <span class="col-md-8">Manufacture of household linen and furnishing textile articles</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Date of Establishment</span>
                            <span class="col-md-8">May 20, 2011</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Plant Location</span>
                            <span class="col-md-8">Binan, Laguna</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Affiliates</span>
                            <span class="col-md-8">
                                <ul style="list-style:none;padding:0;">
                                    <li><a href="#">RCP SENIA TRADING/ TRANSPORT 1</a></li>
                                    <li><a href="#">RCP SENIA TRADING/ TRANSPORT 2</a></li>
                                </ul>
                            </span>
                        </div>
                      
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="details-item kt-margin-b-10">
                            <span class="details-label">Products</span>
                            <span class="details-subtext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus enim risus, pretium a metus id, varius facilisis neque. Sed auctor tellus eget ultrices posuere</span>
                        </div>
                        <div class="details-item kt-margin-b-10">
                            <span class="details-label">History and Background</span>
                            <span class="details-subtext">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus enim risus, pretium a metus id, varius facilisis neque. Sed auctor tellus eget ultrices posuere</span>
                        </div>
                     
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="contact">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Contact No.</span>
                            <span class="col-md-8">XXX-XXXX-XXXX</span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Email</span>
                            <span class="col-md-8"><a href="mailto:xxx@xxx.mail">xxx@xxx.mail</a></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Website</span>
                            <span class="col-md-8"><a href="http://www.website.com">www.website.com</a></span>
                        </div>
                        <div class="row kt-margin-b-5">
                            <span class="col-md-4 kt-font-bold">Facebook</span>
                            <span class="col-md-8"><a href="http://www.facebook.com">www.facebook.com</a></span>
                        </div>
                    </div>
                </div>
                <hr />
                <h5>Contact Persons</h5>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in contactPersons">
                            <td>@{{ row.name }}</td>
                            <td>@{{ row.position }}</td>
                            <td>@{{ row.department }}</td>
                            <td>@{{ row.contact_no }}</td>
                        </tr>
                    </tbody>
                </table>
                <hr />
                <h5>Dealer Sales Executives</h5>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Suffix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in dealerSalesExecutive">
                            <td>@{{ row.title }}</td>
                            <td>@{{ row.first_name }}</td>
                            <td>@{{ row.middle_name }}</td>
                            <td>@{{ row.last_name }}</td>
                            <td>@{{ row.suffix }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="requirement">
                <table class="table table-condensed" style="font-size:90%;">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>PO Quantity</th>
                            <th>Suggested Price</th>
                            <th>Additional details</th>
                            <th>Delivery Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in requirement">
                            <td>@{{ row.model }}</td>
                            <td>@{{ row.color }}</td>
                            <td>@{{ row.quantity }}</td>
                            <td>@{{ row.po_quantity }}</td>
                            <td>@{{ row.suggested_price }}</td>
                            <td>
                                <button type="button" @click="showAdditionalDetails()" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" @click="showDeliveryDetail()" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                    <i class="la la-calendar"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="competitors">
                <table class="table table-condensed" style="font-size:90%;">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Price</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in competitors">
                            <td>@{{ row.brand }}</td>
                            <td>@{{ row.model }}</td>
                            <td>@{{ row.price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="terms">
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Price Validity</span>
                    <span class="col-md-8">May 31, 2019</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Deadline of Submission</span>
                    <span class="col-md-8">May 31, 2019</span>
                </div>
                <div class="row kt-margin-b-5">
                    <span class="col-md-4 kt-font-bold">Payment Terms</span>
                    <span class="col-md-8">Strictly C.O.D only</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="kt-portlet__foot">
        <div class="row  kt-pull-right">
            <div class="col-lg-12">
                @if($action == "validate")
                <button type="submit" class="btn btn-success" @click="approveProject()">Approve</button>
                <button type="submit" class="btn btn-danger"  @click="rejectProject()">Reject</button>
                @elseif($action == "cancel")
                <a href="#"class="btn btn-danger">
                    <span class="kt-hidden-mobile">Cancel</span>
                </a>
                @endif
            </div>
        </div>
    </div>
    
 
</div>

@if($action == "view")
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Price Confirmation 
            </h3> 
        </div>
      
    </div>

    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>FPC No.</th>
                    <th>Account Name</th>
                    <th>Date Confirmed</th>
                    <th>Confirmed By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fpc"> 
                    <td>@{{ row.fpc_no }}</td>
                    <td>@{{ row.account_name }}</td>
                    <td>@{{ row.date_confirmed }}</td>
                    <td>@{{ row.confirmed_by }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="{{ url('view-fpc/001')}}" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Purchase Order
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ url('/manage-po/create/001')}}" class="btn btn-primary btn-sm">
                <span class="kt-hidden-mobile">Submit PO</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>PO Ref</th>
                    <th>PO No.</th>
                    <th>Submitted By</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in po"> 
                    <td>@{{ row.po_ref_no }}</td>
                    <td>@{{ row.po_no }}</td>
                    <td>@{{ row.submitted_by }}</td>
                    <td>@{{ row.date_submitted }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Fleet Wholesale Price Confirmation
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <table class="table table-sm table-head-bg-brand">
            <thead>
                <tr>
                    <th>Sales Order No.</th>
                    <th>Ordered Date</th>
                    <th>Customer Name</th>
                    <th>Order Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row,index) in fwpc"> 
                    <td>@{{ row.oracle_so_num }}</td>
                    <td>@{{ row.ordered_date }}</td>
                    <td>@{{ row.customer_name }}</td>
                    <td>@{{ row.order_type }}</td>
                    <td>
                        <span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill kt-badge--rounded">@{{ row.status }}</span>
                    </td>
                    <td nowrap="nowrap">
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></a> 
                        <a href="#" title="View" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-print"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        




    </div>
</div>

@endif;

<!--begin::Modal-->
<div class="modal fade" id="deliveryScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
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
           <!--  <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add row</button>
            </div> -->
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="details-item">
                    <span class="details-label">Name of Body Builder</span>
                    <span class="details-subtext">Almazora</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Rear Body Type</span>
                    <span class="details-subtext">Wingvan</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Additional Items</span>
                    <span class="details-subtext">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Sed vehicula ornare nibh a pulvinar. 
                        Maecenas hendrerit tincidunt porta.
                    </span>
                </div>      
                <!-- <div class="form-group">
                    <label>Name of Body Builder</label>
                    <input type="text" class="form-control" placeholder="Body builder" />
                </div>
                <div class="form-group">
                    <label>Rear Body Type</label>
                    <input type="text" class="form-control" name="fname" placeholder="Rear Body Type" >
                </div>  
                <div class="form-group">
                    <label>Additional Items</label>
                    <textarea class="form-control"></textarea>
                </div>  -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->



<!--begin::Modal-->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">          
                <div class="form-group">
                    <label>Are you sure to cancel this project? Kindly state your reason.</label>
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


</div> <!-- end of app wrapper -->
@stop


@push('scripts')
<script>
    var vm =  new Vue({
        el : "#app",
        data: {

            contactPersons : [
                {
                    name : "Contact 1",
                    position : "Manager",
                    department : "Sales",
                    contact_no : "09466055244"
                },
                {
                    name : "Contact 2",
                    position : "Manager 2",
                    department : "Sales",
                    contact_no : "09466055244"
                }
            ],
            dealerSalesExecutive : [
                {
                    title : "Mr.",
                    first_name : "Paul",
                    middle_name : "Matuts",
                    last_name : "Alcabasa",
                    suffix : "Jr."
                },
                {
                    title : "Mr.",
                    first_name : "Paul",
                    middle_name : "Matuts",
                    last_name : "Alcabasa",
                    suffix : "Jr."
                }
            ],
            requirement : [
                {
                    model : "D-MAX RZ4E 4x2 Cab/Chassis",
                    color : "SPLASH WHITE",
                    quantity : "15",
                    po_quantity : "10",
                    suggested_price : "1,200,000.00",
                    body_builder : "Almazora",
                    rear_body : "N/A",
                    additional_items : "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
                },
                {
                    model : "D-MAX RZ4E 4x2 Cab/Chassis",
                    color : "SPLASH WHITE",
                    quantity : "20",
                    po_quantity : "20",
                    suggested_price : "1,200,000.00",
                    body_builder : "Almazora",
                    rear_body : "Wingvan",
                    additional_items : "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
                }
            ],
            competitors : [
                {
                    brand : "Hino",
                    model : "CAB XXXX111",
                    price : "1,200,000.00"
                },
                {
                    brand : "Hino",
                    model : "CAB XXXX111",
                    price : "1,200,000.00"
                }
            ],
            fpc : [
                {
                    fpc_no : "FPC001",
                    account_name : "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                    date_confirmed : "May 22, 2019",
                    confirmed_by : "Paul Alcabasa",
                    status : "Approved"

                }
            ],
            po : [
                {
                    po_ref_no : 'PO001',
                    po_no : 'CUSTPO11',
                    submitted_by : 'Mary Jan Watson',
                    date_submitted : 'May 23, 2019',
                    status : 'Approved'
                }
            ],
            fwpc : [
                {
                    oracle_so_num : "3010000123",
                    ordered_date : "May 30, 2019",
                    customer_name : "ISUZU AUTOMOTIVE DEALERSHIP, INC.",
                    order_type : "FLT.Sales Order (LCV A)",
                    status : "Booked"
                }
            ]
        },
        methods : {
            showDeliveryDetail(){
                $("#deliveryScheduleModal").modal('show');
            },
            showAdditionalDetails(){
                $("#additionalDetailsModal").modal('show');
            },
            confirmReject(){
                Swal.fire({
                    type: 'error',
                    title: 'Project has been rejected.',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-projects')}}";
                    }
                });
            },
            rejectProject(){
                $("#rejectModal").modal('show');
            },
            approveProject(){
                 Swal.fire({
                    type: 'success',
                    title: 'Project has been approved!',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose : function(){
                        window.location.href = "{{ url('all-projects')}}";
                    }
                })
            }
        },
        created: function () {
            // `this` points to the vm instance
          
        },
        mounted : function () {
          
        }
    });
</script>
@endpush