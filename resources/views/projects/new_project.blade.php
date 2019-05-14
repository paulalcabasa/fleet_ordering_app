@extends('_layouts.metronic')

@section('page-title', 'New Project')

@section('content')

<div class="kt-portlet" id="app">
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
                                    2) Requirement
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-list"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    3) Competitors
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-responsive"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    4) Terms and Conditions
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
                        <div class="kt-heading kt-heading--md">Select account</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Account Name</label>
                                    <select class="form-control" id="sel_customer" v-model="selected_customer" v-select></select>
                                    <span class="form-text text-muted">Name of the customer</span>
                                </div>
                                <div class="form-group">
                                    <label>Project Source</label>
                                    <select class="form-control" id="sel_project_source" v-model="selected_project_source" v-select></select>
                                    <span class="form-text text-muted">Select the project source</span>
                                </div>
                                <div class="form-group">
                                    <label>Registration Date</label>
                                    <input type="text" class="form-control"  disabled="disabled" name="fname" placeholder="Registration Date"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Date of registration</span>
                                </div> 
                                <div class="form-group">
                                    <label>Organization Type</label>
                                    <input type="text" class="form-control" disabled="disabled" name="fname" placeholder="Organization Type" aria-describedby="fname-error">
                                    <span class="form-text text-muted">organization type</span>
                                </div>
                                <div class="form-group">
                                    <label>TIN</label>
                                    <input type="text" class="form-control" disabled="disabled" name="fname" placeholder="TIN" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter TIN number</span>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" disabled="disabled"></textarea>
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
                                    <label>Name of Body Builder</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Body Builder Name"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter body builder name</span>
                                </div>
                                <div class="form-group">
                                    <label>Rear Body Type</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Rear Body Type"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter rear body type</span>
                                </div>  



                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Model</th>
                                                    <th>Color</th>
                                                    <th>Quantity</th>
                                                    <th>Particulars</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
                                                    <td><input type="text" name="" class="form-control"/></td>
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
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm "/></td>
                                                <td><input type="text" name="" class="form-control form-control-sm"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <input type="text" class="form-control" id="price_validity" placeholder="Price Validity"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter date of establishment</span>
                                </div>
                                <div class="form-group">
                                    <label>Deadline of Submission</label>
                                    <input type="text" class="form-control" id="deadline_of_submission" placeholder="Deadline of Submission" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter deadline of submission</span>
                                </div> 
                                <div class="form-group">
                                    <label>Delivery Schedule</label>
                                    <input type="text" class="form-control" id="delivery_schedule" placeholder="Delivery Schedule" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter delivery schedule</span>
                                </div> 
                                <div class="form-group">
                                    <label>Mode of Payment</label>
                                    <input type="text" class="form-control" id="mode_of_payment" placeholder="Mode of Payment"  aria-describedby="fname-error">
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
                        swal.fire({
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

var Select2 = function(customerOptions,projectSourceOptions){

    var initSelCustomer = function(customerOptions){
    
        $('#sel_customer').select2({
            placeholder: "Select a customer",
            data: customerOptions
        });
    }

    var initSelProjectSource = function(projectSourceOptions){
    
        $('#sel_project_source').select2({
            placeholder: "Select a project source",
            data: projectSourceOptions
        });
    }

    return {
        init : function(customerOptions,projectSourceOptions){
            initSelCustomer(customerOptions);
            initSelProjectSource(projectSourceOptions);
        }
    };
}();

var DatePicker = function(){

    var priceValidity = function(){
        $('#price_validity').datetimepicker({
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
        $('#delivery_schedule').datetimepicker({
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
        }
    };
}();

jQuery(document).ready(function() { 
    KTWizard1.init();
    DatePicker.init();
    ///Select2.init();
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
            selected_customer : 0,
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
            selected_project_source : 0
        },
        methods : {
           
        },
        created: function () {
      
        },
        mounted : function () {
            Select2.init(this.customerOptions, this.projectSourceOptions);
        }
    });

  
</script>
@endpush