@extends('_layouts.metronic')

@section('page-title', 'New Customer')

@section('content')

<div class="kt-portlet">
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
                                    1) Account Details
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
                                    3) Contact Persons
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-responsive"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    4) Other Details
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-globe"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    5) Review and Submit
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
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-heading kt-heading--md">Enter the customer details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Dealer</label>
                                    <input type="text" class="form-control" name="dealer_name" placeholder="Dealer Name"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Name of the registering dealer</span>
                                </div>
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Account Name"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter name of account</span>
                                </div>
                                <div class="form-group">
                                    <label>Organization Type</label>
                                    <select class="form-control"></select>
                                    <span class="form-text text-muted">Select organization type</span>
                                </div>
                                <div class="form-group">
                                    <label>TIN</label>
                                    <input type="text" class="form-control" name="fname" placeholder="TIN" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter TIN number</span>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control"></textarea>
                                    <span class="form-text text-muted">Please enter the address</span>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 1-->

                    <!--begin: Form Wizard Step 2-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter the Contact Details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Contact No.</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Contact No."  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the contact number</span>
                                </div>
                                <div class="form-group">
                                    <label>Fax No.</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Fax No."  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the fax no.</span>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Email"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the email address</span>
                                </div>
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Website" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the website url</span>
                                </div>
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Facebook"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the facebook account or page</span>
                                </div>    

                            </div>
                           
                        </div>
                    </div>
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 2-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter the Contact Persons</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead><tr><th>Name</th> <th>Position</th> <th>Department / Division</th> <th>Contact Number</th></tr></thead> <tbody><tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr> <tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr> <tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr></tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 3-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter other customer details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Date of Establishment</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Date of establishment"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter date of establishment</span>
                                </div>
                                <div class="form-group">
                                    <label>Start of Production</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Start of production" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter start of production</span>
                                </div> 
                                <div class="form-group">
                                    <label>Manpower</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Manpower"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter manpower</span>
                                </div> 
                                <div class="form-group">
                                    <label>Capital</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Capital"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter capital</span>
                                </div>
                                <div class="form-group">
                                    <label>Plant Location</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Plant Location"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the plant location</span>
                                </div>
                                <div class="form-group">
                                    <label>Scope of Business</label>
                                    <select class="form-control"></select>
                                    <span class="form-text text-muted">Please enter scope of business</span>
                                </div>
                                <div class="form-group">
                                    <label>Products</label>
                                    <textarea class="form-control"></textarea>
                                    <span class="form-text text-muted">Please enter products</span>
                                </div>
                                <div class="form-group">
                                    <label>History and Background</label>
                                    <textarea class="form-control"></textarea>
                                    <span class="form-text text-muted">Please enter your first name.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 3-->

                    <!--begin: Form Wizard Step 4-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Review your Details and Submit</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__review">
                                <div class="kt-wizard-v1__review-item">
                                    <div class="kt-wizard-v1__review-title">
                                        Current Address
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Address Line 1<br>
                                        Address Line 2<br>
                                        Melbourne 3000, VIC, Australia
                                    </div>
                                </div>
                                <div class="kt-wizard-v1__review-item">
                                    <div class="kt-wizard-v1__review-title">
                                        Delivery Details
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Package: Complete Workstation (Monitor, Computer, Keyboard &amp; Mouse)<br>
                                        Weight: 25kg<br>
                                        Dimensions: 110cm (w) x 90cm (h) x 150cm (L)
                                    </div>
                                </div>
                                <div class="kt-wizard-v1__review-item">
                                    <div class="kt-wizard-v1__review-title">
                                        Delivery Service Type
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Overnight Delivery with Regular Packaging<br>
                                        Preferred Morning (8:00AM - 11:00AM) Delivery
                                    </div>
                                </div>
                                <div class="kt-wizard-v1__review-item">
                                    <div class="kt-wizard-v1__review-title">
                                        Delivery Address
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Address Line 1<br>
                                        Address Line 2<br>
                                        Preston 3072, VIC, Australia
                                    </div>
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
        })

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

                swal({
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

                        swal({
                            "title": "", 
                            "text": "The application has been successfully submitted!", 
                            "type": "success",
                            "confirmButtonClass": "btn btn-secondary"
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

jQuery(document).ready(function() { 
    KTWizard1.init();
});
</script>
@endpush