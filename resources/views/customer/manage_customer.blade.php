@extends('_layouts.metronic')

@section('page-title', 'New Customer')

@section('content')
<div id="app">

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Customer Details
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                @if ($action == "approve")
                <a href="#" class="btn btn-success">
                    <span class="kt-hidden-mobile">Approve</span>
                </a>

                <a href="#" class="btn btn-danger">
                    <span class="kt-hidden-mobile">Reject</span>
                </a>
                @endif
                @if ($action == "edit")
                <a href="#" class="btn btn-brand">
                    <span class="kt-hidden-mobile">Save Changes</span>
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
                                    1) Account Details
                                </div>
                            </div>
                        </a>
                    <!--    
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
                        </a> -->
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-responsive"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    2) Other Details
                                </div>
                            </div>
                        </a>
                        <a class="kt-wizard-v1__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
                            <div class="kt-wizard-v1__nav-body">
                                <div class="kt-wizard-v1__nav-icon">
                                    <i class="flaticon-globe"></i>
                                </div>
                                <div class="kt-wizard-v1__nav-label">
                                    3) Review and Submit
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
                                    <label>Account Name</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Account Name"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter name of account</span>
                                </div>
                                <div class="form-group">
                                    <label>Organization Type</label>
                                    <select class="form-control" id="sel_org_type" v-model="selected_org_type" v-select></select>
                               <!--      <select class="form-control"></select> -->
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
                                <div class="form-group">
                                    <label>Attachment</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 1-->


                    <!--begin: Form Wizard Step 2-->
                  <!--   <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter the Contact Persons</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead><tr><th>Name</th> <th>Position</th> <th>Department / Division</th> <th>Contact Number</th></tr></thead> <tbody><tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr> <tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr> <tr><td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td> <td><input type="text" name="" class="form-control"></td></tr></tbody></table>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 3-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter other customer details</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form">
                                <div class="form-group">
                                    <label>Date of Establishment</label>
                                    <input type="text" class="form-control" id="txt_date_of_establishment" placeholder="Date of establishment"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter date of establishment</span>
                                </div>
                               <!--  <div class="form-group">
                                    <label>Start of Production</label>
                                    <input type="text" class="form-control" id="txt_start_of_production" placeholder="Start of production" aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter start of production</span>
                                </div>  -->
                               <!--  <div class="form-group">
                                    <label>Manpower</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Manpower"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter manpower</span>
                                </div>  -->
                                <!-- <div class="form-group">
                                    <label>Capital</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Capital"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter capital</span>
                                </div> -->
                                <div class="form-group">
                                    <label>Plant Location</label>
                                    <input type="text" class="form-control" name="fname" placeholder="Plant Location"  aria-describedby="fname-error">
                                    <span class="form-text text-muted">Please enter the plant location</span>
                                </div>
                                <div class="form-group">
                                    <label>Scope of Business</label>
                                    <select class="form-control" id="sel_scope_of_business" data-placeholder="Select scope of business" style="width:100%;">
                                        <option value="" selected="selected">Choose scope of business</option>
                                    </select>
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
                                        Account Details
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Account Name <br/>
                                        Organization Type <br/>
                                        TIN <br/>
                                        Address
                                    </div>
                                </div>
                                <div class="kt-wizard-v1__review-item">
                                    <div class="kt-wizard-v1__review-title">
                                        Other Details
                                    </div>
                                    <div class="kt-wizard-v1__review-content">
                                        Date of Establishment<br/>
                                        Start of Production<br/>
                                        Manpower <br/>
                                        Capital <br/>
                                        Plant Location <br/>
                                        Scope of Business <br/>
                                        Products <br/>
                                        History and Background
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

</div>
@stop

@push('scripts')
<script>

var Select2 = function(organizationOptions){

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

    return {
        init : function(organizationOptions){
            intSelOrg(organizationOptions);
            initSelScope();
        }
    };
}();


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
                            "confirmButtonClass": "btn btn-primary"
                        });*/
                        Swal.fire({
                            type: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose : function(){
                                window.location.href = "view/1";
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


var DatePicker = function(){

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
            startOfProduction(); 
            dateOfEstablishment();
        }
    };
}();

/*// Class definition
var KTTypeahead = function() {

    
    var arr = JSON.parse('{!! json_encode($scope_of_business) !!}');

    var demo2 = function() {
        // constructs the suggestion engine
        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // `states` is an array of state names defined in "The Basics"
            local: arr
        });

        $('#txt_scope_of_business').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: bloodhound
        }); 
      
    }


    return {
        // public functions
        init: function() {
           
            demo2();
        }
    };
}();
*/


jQuery(document).ready(function() { 
    KTWizard1.init();
    DatePicker.init();
  //  KTTypeahead.init();
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
        selected_org_type : 1,
        selected_scope : ""
    },

    created: function () {
        // `this` points to the vm instance
      
    },
    mounted : function () {
        Select2.init(this.organizationOptions);
    }
});


</script>
@endpush