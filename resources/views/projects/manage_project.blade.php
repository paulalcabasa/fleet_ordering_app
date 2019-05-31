@extends('_layouts.metronic')

@section('page-title', 'New Project')

@section('content')


<div id="app">

<div class="kt-portlet">
     <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Project
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                @if ($action == "validate")
                <a href="#" @click="approveProject()" class="btn btn-success">
                    <span class="kt-hidden-mobile">Approve</span>
                </a>

                <a href="#" @click="rejectProject()" class="btn btn-danger">
                    <span class="kt-hidden-mobile">Reject</span>
                </a>
                @elseif ($action == "edit")
                <a href="#" class="btn btn-success">
                    <span class="kt-hidden-mobile">Save Changes</span>
                </a>
                @elseif ($action == "cancel")
                <a href="#" class="btn btn-danger">
                    <span class="kt-hidden-mobile">Cancel</span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_wizard_v1" data-ktwizard-state="first">
            <div class="kt-grid__item">

                <!--begin: Form Wizard Nav -->
                <div class="kt-wizard-v1__nav">
                    <div class="kt-wizard-v1__nav-items">
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-bus-stop"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    1) Account
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-list"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    2) Contact Information
                                </div>
                            </div>
                        </a>
                      
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-list"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    3) Requirement
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-list"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    4) Competitors
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-responsive"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    5) Terms and Conditions
                                </div>
                            </div>
                        </a>
                     
                    </div>
                </div>
                <!--end: Form Wizard Nav -->
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                <!--begin: Form Wizard Form-->
                <form class="kt-form" id="kt_form" novalidate="novalidate">
                    <!--begin: Form Wizard Step 1-->
                    <div class="kt-wizard-v1__content kt-wizard-sm" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-heading kt-heading--md">Select account</div>
                        <div class="kt-form__section kt-form__section--first kt-wizard-sm">
                            <div class="kt-wizard-v1__form">
                                <!-- <div class="form-group">
                                    <label>Account No.</label>
                                    <input type="text" class="form-control"  />
                                    <span class="form-text text-muted">Autogenerated</span>
                                </div> -->
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Project Source</label>
                                        <select class="form-control" id="sel_project_source" v-model="selected_project_source" v-select style="width:100%;"></select>
                                        <span class="form-text text-muted">Select the project source</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Organization Type</label>
                                        <select class="form-control" id="sel_org_type" v-model="selected_org_type" v-select style="width:100%;"></select>
                                        <span class="form-text text-muted">Select organization type</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <div class="typeahead">
                                        <input type="text" class="form-control" id="txt_account_name" autocomplete="off" dir="ltr" placeholder="Account Name"  />
                                    </div> 
                                    <span class="form-text text-muted">Please enter name of account</span>
                                </div>
                                     
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>TIN</label>
                                        <input type="text" class="form-control" value="" id="txt_tin" placeholder="TIN" aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter TIN number (XXX-XXX-XXXXX)</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Attachment</label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control"></textarea>
                                    <span class="form-text text-muted">Please enter the address</span>
                                </div>

                                <div class="form-group">
                                    <label>Business Style</label>
                                    <select class="form-control" id="sel_scope_of_business" data-placeholder="Select scope of business" style="width:100%;">
                                        <option value="" selected="selected">Choose business style</option>
                                    </select>
                                    <span class="form-text text-muted">Please select business style</span>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Date of Establishment</label>
                                        <input type="text" class="form-control" id="txt_date_of_establishment" placeholder="Date of establishment"  aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter date of establishment</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Plant Location</label>
                                        <input type="text" class="form-control" name="fname" placeholder="Plant Location"  aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter the plant location</span>
                                    </div>
                                
                                </div>
                             
                                
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Products</label>
                                        <textarea class="form-control"></textarea>
                                        <span class="form-text text-muted">Please enter products</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>History and Background</label>
                                        <textarea class="form-control"></textarea>
                                        <span class="form-text text-muted">Please enter your first name.</span>
                                    </div>
                                </div>
                               
                                 <div class="form-group">
                                    <label>Affiliates</label>
                                    <select class="js-example-basic-multiple" id="sel_affiliates" name="affiliates[]" multiple="multiple" style="width:100%;">
                                     
                                    </select>                            
                                    <span class="form-text text-muted">Select affiliates</span>
                                </div>  
                                
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 1-->

                    <!--begin: Form Wizard Step 2-->
                    <div class="kt-wizard-v1__content kt-wizard-md" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter the Contact Details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" name="fname" placeholder="Contact No."  aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter the contact number</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="txt_email" placeholder="Email"  aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter the email address</span>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                       <label>Website</label>
                                        <input type="text" class="form-control" name="fname" placeholder="Website" aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter the website url</span> 
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control" name="fname" placeholder="Facebook"  aria-describedby="fname-error">
                                        <span class="form-text text-muted">Please enter the facebook account or page</span>
                                    </div>
                                    
                                </div>
                                 
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="kt-pull-left">Contact Persons</h4>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th> 
                                                <th>Position</th> 
                                                <th>Department</th> 
                                                <th>Contact Number</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <tr v-for="(row, index) in contactPersons">
                                                <td><input type="text" v-model="row.name" class="form-control form-control-sm"></td> 
                                                <td><input type="text" v-model="row.position" class="form-control form-control-sm"></td>
                                                <td><input type="text" v-model="row.department" class="form-control form-control-sm"></td>
                                                <td><input type="text" v-model="row.contact_number" class="form-control form-control-sm"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success kt-pull-right" @click="addContactRow">Add</button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="kt-pull-left">Dealer Sales Executive</h4>
                                    <table class="table">
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
                                            <tr v-for="(row, index) in salesPersons">
                                                <td><input type="text" size="4" v-model="row.title" class="form-control form-control-sm"></td> 
                                                <td><input type="text" v-model="row.first_name" class="form-control form-control-sm"></td>
                                                <td><input type="text" v-model="row.middle_name" class="form-control form-control-sm"></td>
                                                <td><input type="text" v-model="row.last_name" class="form-control form-control-sm"></td>
                                                <td><input type="text" size="4" v-model="row.suffix" class="form-control form-control-sm"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success kt-pull-right" @click="addSalesPersonRow">Add</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 2-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter your requirement</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group row">
                                    <label class="col-3 col-form-label">Vehicle Type</label>
                                    <div class="col-9">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio kt-radio--brand">
                                                <input type="radio" name="radio4"> Light Commercial Vehicle
                                                <span></span>
                                            </label>
                                            <label class="kt-radio kt-radio--brand">
                                                <input type="radio" name="radio4"> Commercial Vehicle
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Model</label>
                                        <select class="form-control">
                                            <option>Select a model</option>
                                            <optgroup label="D-MAX">
                                                <option>D-MAX RZ4E 4X2 LS MT</option>
                                                <option>180 D-MAX 4x4 LS MT</option>
                                            </optgroup>
                                            <optgroup label="MU-X">
                                                <option>mu-X 4x2 LS-A MT 2.5</option>
                                                <option>mu-X 4x2 LS-A AT Luxe</option>
                                            </optgroup>
                                            <optgroup label="N-SERIES">
                                                <option>NLR77 NON-TILT 80A</option>
                                                <option>NLR77 LWB Non-Tilt JB</option>
                                            </optgroup>
                                            <optgroup label="F-SERIES">
                                                <option>090FORWARD FV</option>
                                                <option>120FVM34UL-TNE EXT CHAS</option>
                                            </optgroup>
                                            <optgroup label="Q-SERIES">
                                                <option>QKR77-MB</option>
                                                <option>QKR77 Non-Tilt 80A</option>
                                            </optgroup>
                                            <optgroup label="C AND E SERIES">
                                                <option>CYZ52Q</option>
                                                <option>EXR51E</option>
                                            </optgroup>
                                        </select>   
                                    </div>
                                    <div class="col-md-6">
                                        <label>Color</label>
                                        <div class="input-group">
                                            <select class="form-control">
                                                <option>Select a color</option>
                                                <option>TITANIUM SILVER</option>
                                                <option>RED SPINEL MICA</option>
                                                <option>ARC WHITE</option>
                                                <option>SPLASH WHITE</option>
                                                <option>OBSIDIAN GRAY MICA</option>
                                                <option>BLACKISH DARK</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                   
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Model</th>
                                                    <th>Color</th>
                                                    <th>Quantity</th>
                                                    <th>Suggested Price</th>
                                                    <th>Additional Details</th>
                                                    <th>Delivery Schedule</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(row,index) in vehicleRequirement">
                                                    <td>@{{ row.model }}</td>
                                                    <td>@{{ row.color }}</td>
                                                    <td><input type="text" name="" class="form-control form-control-sm" size="4"/></td>
                                                    <td><input type="text" name="" class="form-control form-control-sm"/></td>
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
                                </div>                 
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 3-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter the Competitors</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizafrd-v1__form">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Brand</label>
                                        <div class="typeahead">
                                            <input class="form-control" id="txt_competitor_brand" type="text" dir="ltr" placeholder="Competitor brand">
                                        </div> 
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Model</label>
                                        <div class="input-group">
                                            <div class="typeahead">
                                                <input class="form-control" id="txt_model_brand" type="text" dir="ltr" placeholder="Competitor brand">
                                            </div> 
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                 
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width:30%;">HINO</td>
                                                    <td style="width:20%;">Hino Ranger</td>
                                                    <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 3-->

                    <!--begin: Form Wizard Step 4-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter other customer details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Price Validity</label>
                                    <input type="text" class="form-control" id="txt_price_validity" placeholder="Price Validity"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter price validity</span>
                                </div>
                                <div class="form-group">
                                    <label>Deadline of Submission</label>
                                    <input type="text" class="form-control" id="deadline_of_submission" placeholder="Deadline of Submission" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter deadline of submission</span>
                                </div> 
                                <div class="form-group">
                                    <label>Payment Terms</label>
                                    <select class="form-control" id="sel_payment_term" v-model="selected_payment_term" v-select style="width:100%;"></select>      
                                    <span class="form-text text-muted">Please enter mode of payment</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 4-->

                    <!--begin: Form Actions -->
                    <div class="kt-form__actions">
                        <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                            Previous
                        </div>
                        <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                            Submit
                        </div>
                        <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                            Next Step
                        </div>
                    </div>
                    <!--end: Form Actions -->
                </form>

                <!--end: Form Wizard Form-->
            </div>
        </div>
    </div>
</div>

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
                                    <td><input type="text" class="form-control form-control-sm" /></td>
                                    <td><input type="text" class="form-control form-control-sm delivery_date" /></td>
                                </tr>
                            </tbody>
                        </table>                    
                    </div>
                </div>
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add row</button>
            </div>
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
                <div class="form-group">
                    <label>Name of Body Builder</label>
                    <input type="text" class="form-control" placeholder="Body builder" />
                    <span class="form-text text-muted">Please a body builder</span>
                </div>
                <div class="form-group">
                    <label>Rear Body Type</label>
                    <input type="text" class="form-control" name="fname" placeholder="Rear Body Type" >
                    <span class="form-text text-muted">Please enter rear body type</span>
                </div>  
                <div class="form-group">
                    <label>Additional Items</label>
                    <textarea class="form-control"></textarea>
                    <span class="form-text text-muted">Please enter additional items</span>
                </div> 
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

</div>
<!-- end app -->

@stop

@push('scripts')
<script>


// Class definition
var KTWizard1 = function () {
    // Base elements
    var wizardEl;
    var formEl;
    var validator;
    var wizard;
    
    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        wizard = new KTWizard('kt_wizard_v1', {
            startStep: 1
        });

        // Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
            if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        });

        // Change event
        wizard.on('change', function(wizard) {
            setTimeout(function() {
                KTUtil.scrollTop(); 
            }, 500);
        });
    }   

    var initValidation = function() {
        validator = formEl.validate({
            // Validate only visible fields
            ignore: ":hidden",

            // Validation rules
            rules: {    
                //= Step 1
                address1: {
                    required: true 
                },
                postcode: {
                    required: true
                },     
                city: {
                    required: true
                },   
                state: {
                    required: true
                },   
                country: {
                    required: true
                },   

                //= Step 2
                package: {
                    required: true
                },
                weight: {
                    required: true
                },  
                width: {
                    required: true
                },
                height: {
                    required: true
                },  
                length: {
                    required: true
                },             

                //= Step 3
                delivery: {
                    required: true
                },
                packaging: {
                    required: true
                },  
                preferreddelivery: {
                    required: true
                },  

                //= Step 4
                locaddress1: {
                    required: true 
                },
                locpostcode: {
                    required: true
                },     
                loccity: {
                    required: true
                },   
                locstate: {
                    required: true
                },   
                loccountry: {
                    required: true
                },  
            },
            
            // Display error  
            invalidHandler: function(event, validator) {     
                KTUtil.scrollTop();

                swal.fire({
                    "title": "", 
                    "text": "There are some errors in your submission. Please correct them.", 
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary"
                });
            },

            // Submit valid form
            submitHandler: function (form) {
                
            }
        });   
    }

    var initSubmit = function() {
        var btn = formEl.find('[data-ktwizard-type="action-submit"]');

        btn.on('click', function(e) {
            e.preventDefault();

            if (validator.form()) {
                // See: src\js\framework\base\app.js
                KTApp.progress(btn);
                //KTApp.block(formEl);

                // See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                    success: function() {
                
                        KTApp.unprogress(btn);
                        //KTApp.unblock(formEl);
                       /* swal.fire({
                            "title": "", 
                            "text": "The application has been successfully submitted!", 
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
                        });*/


                          Swal.fire({
                            type: 'success',
                            title: 'The application has been successfully submitted!',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose : function(){
                                window.location.href = "all-projects";
                            }
                        });
                    }
                });
            }
        });
    }

    return {
        // public functions
        init: function() {
            wizardEl = KTUtil.get('kt_wizard_v1');
            formEl = $('#kt_form');

            initWizard(); 
            initValidation();
            initSubmit();
        }
    };
}();

var Select2 = function(afiliateOptions,projectSourceOptions,organizationOptions,paymentTermOptions){

    var initSelProjectSource = function(projectSourceOptions){
    
        $('#sel_project_source').select2({
            placeholder: "Select a project source",
            data: projectSourceOptions
        });
    }

   var intSelOrg = function(organizationOptions){
    
        $('#sel_org_type').select2({
            placeholder: "Select an organization type",
            data: organizationOptions
        });
    }

    var initSelScope = function(){
        $("#sel_scope_of_business").select2({
            ajax: {
                placeholder : "Choose scope of business",
                url: "{{ url('/ajax_get_scope') }}",
                dataType: 'json',
                type: 'GET',
                delay: 250,
                data: function (params) {
                    return {
                        q: $.trim(params.term) // search term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data  
                    };
                },
                cache: true
            },
            minimumInputLength: 3,
            allowClear : true
        });
    }

    var initPaymentTerm = function(paymentTermOptions){
        $('#sel_payment_term').select2({
            placeholder: "Select a payment term",
            data: paymentTermOptions
        });
    }

    var affiliates = function(afiliateOptions){
        $('#sel_affiliates').select2({
            placeholder: "Select affiliates",
            data : afiliateOptions
        });
    }

    return {
        init : function(afiliateOptions,projectSourceOptions,organizationOptions,paymentTermOptions){
            initSelProjectSource(projectSourceOptions);
            intSelOrg(organizationOptions);
            initPaymentTerm(paymentTermOptions);
            initSelScope();
            affiliates(afiliateOptions);
        }
    };
}();

var DatePicker = function(){

    var priceValidity = function(){
        $('#txt_price_validity').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    var deadlineOfSubmission = function(){
        $('#deadline_of_submission').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    var deliverySchedule = function(){
        $('.delivery_date').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    var startOfProduction = function(){
        $('#txt_start_of_production').datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
    }

    var dateOfEstablishment = function(){
        $('#txt_date_of_establishment').datetimepicker({
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
            priceValidity(); 
            deadlineOfSubmission();
            deliverySchedule();
            startOfProduction(); 
            dateOfEstablishment();
        }
    };
}();

var KTTypeahead = function() {


    var inputCompetitorBrand = function() {
    
        var arr = [
            'Hino',
            'JAC',
            'Toyota',
            'Mitsubishi',
            'Honda',
            'MAN'
        ];
        // constructs the suggestion engine
        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // `states` is an array of state names defined in "The Basics"
            local: arr
        });

        $('#txt_competitor_brand').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'brand',
            source: bloodhound
        }); 
    }

     var inputAccountName = function(accountsList) {
     
       /* var arr = [
            'Hino',
            'JAC',
            'Toyota',
            'Mitsubishi',
            'Honda',
            'MAN'
        ];*/
        // constructs the suggestion engine
        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // `states` is an array of state names defined in "The Basics"
            local: accountsList
        });

        $('#txt_account_name').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'brand',
            source: bloodhound
        }); 
    }

    

    var inputCompetitorModel = function() {
    
        var arr = [
            'Refine M3',
            'Refine S7 ',
            'CAB-OVER 195h 19,500 GVW',
            'CAB-OVER 195h DC 19,500 GVW Double Cab',
            'CONVENTIONAL 238 23,000 GVW',
            'Hi-Ace'
        ];
        // constructs the suggestion engine
        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // `states` is an array of state names defined in "The Basics"
            local: arr
        });

        $('#txt_model_brand').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'model',
            source: bloodhound
        }); 
      
    }
    

    return {
        // public functions
        init: function(accountsList) {
           
            inputCompetitorBrand();
            inputCompetitorModel();
            inputAccountName(accountsList);
        }
    };
}();

// Class definition

var KTInputmask = function () {
    
    // Private functions
    var demos = function () {
        // date format
       /* $("#txt_date_of_establishment").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
            autoUnmask: true
        });*/

        // custom placeholder        
        $("#kt_inputmask_2").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
        });
        
        // phone number format
        $("#kt_inputmask_3").inputmask("mask", {
            "mask": "(999) 999-9999"
        }); 

        // empty placeholder
        $("#txt_tin").inputmask({
            "mask": "999-999-99999",
            placeholder: "XXX-XXX-XXXXX" // remove underscores from the input mask
        });

        // repeating mask
        $("#kt_inputmask_5").inputmask({
            "mask": "9",
            "repeat": 10,
            "greedy": false
        }); // ~ mask "9" or mask "99" or ... mask "9999999999"
        
        // decimal format
        $("#kt_inputmask_6").inputmask('decimal', {
            rightAlignNumerics: false
        }); 
        
        // currency format
        $("#kt_inputmask_7").inputmask('â‚¬ 999.999.999,99', {
            numericInput: true
        }); //123456  =>  â‚¬ ___.__1.234,56

        //ip address
        $("#kt_inputmask_8").inputmask({
            "mask": "999.999.999.999"
        });  

        //email address
        $("#txt_email").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });        
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

jQuery(document).ready(function() { 
    KTWizard1.init();
    DatePicker.init();
    KTInputmask.init();
});
</script>

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


    var vm =  new Vue({
        el : "#app",
        data: {
            customerOptions : [
                {
                    id : 0,
                    text : "RCP SENIA TRADING/ RCP SENIA TRANSPORT"
                },
                {
                    id : 1,
                    text : "MUNICIPAL GOVERNMENT OF CALAUAG"
                },
                {
                    id : 2,
                    text : "HOME OFFICE SPECIALIST"
                }
            ],
            accountsList : [
                "RCP SENIA TRADING/ RCP SENIA TRANSPORT",
                "MUNICIPAL GOVERNMENT OF CALAUAG",
                "HOME OFFICE SPECIALIST"  
            ],
            projectSourceOptions : [
                {
                    id : 0,
                    text : "Walk-in"
                },
                {
                    id : 1,
                    text : "Referrals"
                },
                {
                    id : 2,
                    text : "Telemarketing"
                },
                {
                    id : 3,
                    text : "Events"
                },
                {
                    id : 4,
                    text : "Others"
                }
            ],
            organizationOptions  : [
                {
                    id : 0,
                    text : "GOVERNMENT"
                },
                {
                    id : 1,
                    text : "PRIVATE"
                }
            ],
            vehicleRequirement : [
                {
                    model : "D-MAX RZ4E 4x2 Cab/Chassis",
                    color : "SPLASH WHITE",
                    quantity : "",
                    suggested_price : "",
                    additional_items : "",
                    body_builder : "",
                    rear_body_type : ""
                },
                {
                    model : "mu-X 4x2 LS-A AT Luxe",
                    color : "RED SPINEL MICA",
                    quantity : "",
                    suggested_price : "",
                    additional_items : "",
                    body_builder : "",
                    rear_body_type : ""
                },
                {
                    model : "QKR77-MB",
                    color : "ARC WHITE",
                    quantity : "",
                    suggested_price : "",
                    additional_items : "",
                    body_builder : "",
                    rear_body_type : ""
                }
            ],
            paymentTermsOptions : [
                {
                    id : 0,
                    text : 'Strictly C.O.D. only.'
                },
                {
                    id : 1,
                    text : `N-Series: Strictly 45 days from date of pull-out from IPC.F-Series: 
                            Strictly 60 days from date of pull-out from IPC.
                            Given that dealer has no past due/ overdue invoices. 
                            Otherwise, payment terms is C.O.D.`
                },
                {
                    id : 2,
                    text : `Given that dealer has no past due/ overdue invoices. Otherwise, payment terms is C.O.D.`
                },
                {
                    id : 3,
                    text : `N-Series: Strictly 30 days from date of pull-out from IPC.
                            F-Series: Strictly 45 days from date of pull-out from IPC.
                            Given that dealer has no past due/ overdue invoices. 
                            Otherwise, payment terms is C.O.D.`
                },
                {
                    id : 4,
                    text : `Strictly 15 days upon pull-out of chassis from IPC`
                },
                {
                    id : 5,
                    text : `Strictly 30 days upon pull-out of chassis from IPC.`
                },
                {
                    id : 6,
                    text : `Strictly 60 days upon pull-out of chassis from IPC`
                },
                {
                    id : 7,
                    text : `Strictly 90 days upon pull-out of chassis from IPC`
                },
                {
                    id : 8,
                    text : `Luzon Dealers: Strictly 45 days from date of pull-out from IPC.
                            VisMin Dealers: Strictly 60 days from date of pull-out from IPC.`
                },
                {
                    id : 9,
                    text : `Luzon Dealers: Strictly 30 days from date of pull-out from IPC.
                            VisMin Dealers: Strictly 45 from date of pull-out from IPC.
                            Given that dealer has no past due/ overdue invoices. 
                            Otherwise, payment terms is C.O.D.`
                },
                {
                    id : 10,
                    text : `N-Series: Strictly 45 days from date of pull-out from IPC.
                            F-Series: Strictly 60 days from date of pull-out from IPC.
                            Given that dealer has no past due/ overdue invoices. 
                            Otherwise, payment terms is C.O.D.`
                },
                {
                    id : 11,
                    text : 'Standard payment terms per series.'
                },
                {
                    id : 12,
                    text : `120 days upon pull-out of the chassis from IPC. Given that the dealer has no over due invoices. Otherwise, C.O.D.`
                },
                {
                    id : 13,
                    text : `Strictly C.O.D. for D-Max RZ4E LT MT. 30 days from pull-out from IPC for D-Max 4x2 Single Cab & Chassis (RT66).`
                },
                {
                    id : 14,
                    text : `30% - Downpayment 
                            70% - To be paid within 5 months`
                },
                {
                    id : 15,
                    text : `Strictly 30 days upon pull-out of chassis from IPC - for D-Max Cab and Chassis only.`
                }

            ],
            selected_org_type : 1,
            selected_project_source : 0,
            selected_payment_term : 0,
            contactPersons : [],
            salesPersons : []
        },
        methods : {
            addContactRow(){
                this.contactPersons.push(
                    {
                        name : "",
                        position : "",
                        department : "",
                        contact_number : ""
                    }
                );
            },
            addSalesPersonRow(){
                this.salesPersons.push(
                    {
                        title : "",
                        first_name : "",
                        middle_name : "",
                        last_name : "",
                        suffix : ""
                    }
                );
            },
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
      
        },
        mounted : function () {
            Select2.init(this.customerOptions, this.projectSourceOptions, this.organizationOptions,this.paymentTermsOptions);
            KTTypeahead.init(this.accountsList);
        }
    });

  
</script>
@endpush