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
         
                    </div>
                </div>
                <!--end: Form Wizard Nav -->
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                <!--begin: Form Wizard Form-->
                <form class="kt-form" id="kt_form" novalidate="novalidate" method="post"  enctype="multipart/form-data" >
                    <!--begin: Form Wizard Step 1-->
                    <div class="kt-wizard-v1__content kt-wizard-sm" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-heading kt-heading--md">Select account</div>
                        <div class="kt-form__section kt-form__section--first kt-wizard-sm">
                            <div class="kt-wizard-v1__form">
                                
                                <div class="form-group row">
                                    <div class="col-lg-8">
                                        <label>Account Name</label>
                                         <div class="typeahead">
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                v-model.lazy="accountDetails.account_name"   
                                                id="txt_account_name" 
                                                autocomplete="off" 
                                                name="account_name" 
                                                dir="ltr" 
                                                placeholder="Account Name"  
                                            />
                                        </div> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Fleet Category</label>
                                        <select 
                                            class="form-control" 
                                            id="sel_fleet_category" 
                                            v-model.lazy="accountDetails.fleet_category" 
                                            v-select 
                                            style="width:100%;">
                                            <option value="-1">Choose fleet category</option>
                                            <option v-for="category in fleetCategories" :value="category.fleet_category_id">@{{ category.fleet_category_name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Project Source</label>
                                        <div class="row">
                                            <div :class="accountDetails.selected_project_source != 8 ? 'col-md-12' : 'col-md-6'"> 
                                                <select class="form-control" id="sel_project_source" v-model="accountDetails.selected_project_source" v-select style="width:100%;"></select>
                                            </div>
                                            <div :class="accountDetails.selected_project_source == 8 ? 'col-md-6' : ''" v-show="accountDetails.selected_project_source == 8">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    value="" 
                                                    id="txt_others" 
                                                    
                                                    v-model.lazy="accountDetails.others" 
                                                    placeholder="Enter project source"
                                                           
                                                /> 
                                            </div>
                                        </div>
                                     <!--    <span class="form-text text-muted">Select the project source</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Organization Type</label>
                                        <select class="form-control" id="sel_org_type" v-model.lazy="accountDetails.selected_org_type" v-select style="width:100%;"></select>
                                        
                             <!--            <span class="form-text text-muted">Select organization type</span> -->
                                    </div>
                                </div>
                                
                                <div class="form-group row" v-if="accountDetails.selected_org_type == 1">
                                    <div class="col-lg-6">
                                        <label>Bidding Ref. No</label>
                                        <input type="text" class="form-control" value="" v-model.lazy="accountDetails.bid_ref_no" name="bid_ref_no" placeholder="Bidding Reference No." />
                                      <!--   <span class="form-text text-muted">Please enter bidding ref. no</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Bid Docs Amount</label>
                                        <input type="text" class="form-control" value="" v-model.lazy="accountDetails.bid_docs_amount" name="bid_docs_amount" placeholder="Bidding Docs Amount" />
                                      <!--   <span class="form-text text-muted">Please enter bidding docs amount</span> -->
                                    </div>
                                </div>

                                <div class="form-group row" v-if="accountDetails.selected_org_type == 1">
                                    <div class="col-lg-6">
                                        <label>Pre-bid schedule</label>
                                        <input type="date" class="form-control" value="" v-model.lazy="accountDetails.pre_bid_sched" name="pre_bid_sched" id="txt_pre_bid_sched" placeholder="Bidding Reference No." />
                                    <!--     <span class="form-text text-muted">Please enter pre bid schedule</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Bid Date Schedule</label>
                                        <input type="date" class="form-control" value="" v-model.lazy="accountDetails.bid_date_sched" name="bid_date_sched" placeholder="Bidding Date Schedule" />
                               <!--          <span class="form-text text-muted">Please enter bid date sched</span> -->
                                    </div>
                                </div>

                                <div class="form-group row" v-if="accountDetails.selected_org_type == 1">
                                    <div class="col-lg-6">
                                        <label>Bidding Venue</label>
                                        <input type="text" class="form-control" value="" v-model.lazy="accountDetails.bidding_venue" name="bidding_venue" placeholder="Bidding Venue" />
                                       <!--  <span class="form-text text-muted">Please enter bidding venue</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Approved budget cost</label>
                                        <input type="text" class="form-control" value="" v-model.lazy="accountDetails.approved_budget_cost" name="approved_budget_cost" placeholder="Approved buget cost" />
                                <!--         <span class="form-text text-muted">Please enter approved budget cost</span> -->
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>TIN</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="tin" 
                                            id="txt_tin" 
                                            placeholder="TIN" 
                                            aria-describedby="fname-error">
                                       <!--  <span class="form-text text-muted">Please enter TIN number (XXX-XXX-XXXXX)</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Attachment</label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" @change="validateFileSize('customer')" class="custom-file-input" ref="customFile" name="attachment[]" id="attachment" multiple="true">
                                            <label class="custom-file-label" for="attachment">@{{ file_label }}</label>
                                            <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                                                <li v-for="(row,index) in attachments">
                                                    <a target="_blank" :href="baseUrl + '/' + row.directory + '/' + row.filename" download v-if="row.directory != null">@{{ row.orig_filename }}</a>
                                                    <span v-if="row.directory == null">@{{ row.orig_filename }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>

                                    <textarea 
                                        class="form-control" 
                                        name="address" 
                                        :value="accountDetails.address"
                                         @change="v => accountDetails.address = v.target.value"
                                    ></textarea>
                                  <!--   v-model="accountDetails.address" <span class="form-text text-muted">Please enter the address</span> -->
                                </div>

                                <div class="form-group row">

                                    <div class="col-lg-6">
                                        <label>Business Style</label>
                                        <div class="typeahead">
                                            <input type="text" class="form-control" v-model.lazy="accountDetails.business_style" id="txt_business_style" autocomplete="off" name="business_style" dir="ltr" placeholder="Business style"  />
                                        </div>                
                                        <!-- <select class="form-control" name="business_style" id="sel_scope_of_business" data-placeholder="Select business style" style="width:100%;">
                                            <option value="-1" selected="selected">Choose business style</option>
                                        </select>
                                        <span class="form-text text-muted"></span>  -->
                                    </div>

                                    <div class="col-lg-6">
                                        <label>Date of Establishment</label>   
                                        <input type="date" class="form-control" v-model.lazy="accountDetails.establishment_date" />
                                    </div>

                                </div> 
                                
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label>Products</label>
                                        <textarea class="form-control" name="products" v-model.lazy="accountDetails.products"></textarea>
                         <!--                <span class="form-text text-muted">Please enter products</span> -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Company Overview</label>
                                        <textarea class="form-control" name="company_overview" v-model.lazy="accountDetails.company_overview"></textarea>
                                       <!--  <span class="form-text text-muted">Please enter your first name.</span> -->
                                    </div>
                                </div>
                               
                                 <div class="form-group">
                                    <label>Affiliates</label>
                                    <select class="form-control" id="sel_affiliates" v-model.lazy="accountDetails.affiliates" v-select  multiple="multiple" style="width:100%;">
                                     
                                    </select>                            
                                  <!--   <span class="form-text text-muted">Select affiliates</span> -->
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
                                        <div class="input-group">
                                            <input type="text" id="txt_contact_number" class="form-control" v-model="contactNumber">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" @click="addCustContact">Add</button>
                                            </div>
                                        </div>
                                        <ul class="contact-list">
                                            <li class="kt-font-bold" v-for="(row,index) in contactDetails.custContacts">
                                                <a href="#" @click.prevent="deleteContact(index)">
                                                    <i class="flaticon flaticon-delete kt-margin-r-10 kt-font-danger"></i>
                                                </a>
                                                <span>@{{ row.contact_number }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Email</label>
                                        <input type="text" class="form-control" v-model.lazy="contactDetails.email_address" name="email_address"  placeholder="Email"  aria-describedby="fname-error">
                                        <!-- <span class="form-text text-muted">Please enter the email address</span> -->
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                       <label>Website</label>
                                        <input type="text" class="form-control" v-model.lazy="contactDetails.website_url" name="website_url" placeholder="Website" aria-describedby="fname-error">
                                        <!-- <span class="form-text text-muted">Please enter the website url</span>  -->
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control" v-model.lazy="contactDetails.facebook_url" name="facebook_url" placeholder="Facebook"  aria-describedby="fname-error">
                                        <span class="form-text text-muted"></span>
                                    </div>
                                    
                                </div>
                                 
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="kt-pull-left">Contact Persons</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th> 
                                                    <th>Name</th> 
                                                    <th>Position</th> 
                                                    <th>Department</th> 
                                                    <th>Contact Number</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="(row, index) in contactDetails.contactPersons">
                                                    <td>
                                                        <a href="#" @click.prevent="removeContactPerson(index)">
                                                            <i class="flaticon flaticon-delete kt-font-danger"></i>
                                                        </a>
                                                    </td>
                                                    <td><input type="text" v-model.lazy="row.name" class="form-control form-control-sm"></td> 
                                                    <td><input type="text" v-model.lazy="row.position" class="form-control form-control-sm"></td>
                                                    <td><input type="text" v-model.lazy="row.department" class="form-control form-control-sm"></td>
                                                    <td><input type="text" v-model.lazy="row.contact_number" class="form-control form-control-sm"></td>
                                                    <td><input type="text" v-model.lazy="row.email" class="form-control form-control-sm"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-success kt-pull-right" @click="addContactRow">Add</button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row" id="se_wrapper">
                                <h4 class="kt-pull-left">Dealer Sales Executive</h4>
                                <div class="col-lg-12">                        
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                            <select class="form-control" id="sel_sales_persons" v-model="selected_sales_person" v-select  style="width:100%;">
                                                <option value="-1">Select a sales person</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary" type="button" @click="addSalesPerson">Add</button>
                                        </div>   
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Position</th>  
                                                    <th>Mobile No.</th>  
                                                    <th>Email</th>  
                                                    <th></th>  
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="(row, index) in contactDetails.salesPersons">
                                                    <td>
                                                        <a href="#" @click.prevent="removeSalesPersons(index)">
                                                            <i class="flaticon flaticon-delete kt-font-danger"></i>
                                                        </a>
                                                    </td>
                                                    <td>@{{ row.name }}</td>
                                                    <td>@{{ row.position_title }}</td> 
                                                    <td>@{{ row.mobile_no }}</td> 
                                                    <td>@{{ row.email }}</td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Wizard Step 2-->

                    <!--begin: Form Wizard Step 2-->
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                        <div class="kt-heading kt-heading--md">Enter your requirement</div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="kt-wizard-v1__form" >
                               <!--  <div class="form-group row">
                                    <label class="col-3 col-form-label">Vehicle Type</label>
                                    <div class="col-9">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio kt-radio--brand" v-for="(row,index) in vehicleTypes">
                                                <input type="radio" name="vehicle_types" :value="row.vehicle_type_id" @click="getVehicles(row.vehicle_type_abbrev)"> @{{ row.vehicle_type_name }}
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label>Model</label>
                                        <select class="form-control" id="sel_vehicle_models" v-model="selected_model" v-select style="width:100%;">
                                            <option value="-1">Select a model</option>
                                            <optgroup v-for="(row,index) in  vehicle_models" :label="row.model">
                                                <option 
                                                    v-for="(variant,index) in row.variants" 
                                                    :value="variant.id" 
                                                    :data-vehicle_type="variant.vehicle_type"
                                                    :data-variant="variant.variant"
                                                >@{{ variant.value}}</option>
                                            </optgroup>
                                        </select>   
                                    </div>
                                    <div class="col-md-5">
                                        <label>Color</label>
                                        <select class="form-control" id="sel_vehicle_colors" v-model="selected_color" v-select style="width:100%;">
                                            <option value="-1">Select a color</option>
                                            <option v-for="(row,index) in vehicleColors" :value="row.id">@{{ row.text }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary kt-margin-t-25" type="button" @click="addVehicle">Add</button>
                                    </div>
                                </div>
                                   
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered">
                                                <thead  class="bg-light-gray-2">
                                                    <tr>
                                                        <th></th>
                                                        <th>Model</th>
                                                        <th>Color</th>
                                                        <th>Quantity</th>
                                                        <th>Suggested Price</th>
                                                        <th>Subtotal</th>
                                                        <th>Other details</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-for="(vehicleGroup,index) in Object.keys(vehicleRequirement)">
                                                    <tr v-for="(model,index) in vehicleRequirement[vehicleGroup]">
                                                        <td>
                                                            <a href="#" @click.prevent="removeVehicle(vehicleGroup,index)">
                                                                <i class="flaticon flaticon-delete kt-font-danger"></i>
                                                            </a>
                                                        </td>

                                                        <td>@{{ model.model }}</td>
                                                        <td>@{{ model.color }}</td>
                                                        <td><input type="text" name="" class="form-control form-control-sm" size="4" v-model="model.quantity"/></td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                name="" 
                                                                class="form-control form-control-sm" 
                                                                v-model="model.suggested_price" 
                                                            />
                                                        </td>
                                                        <td>@{{ (formatPrice(model.suggested_price * model.quantity))}}</td>
                                                     <!--    <td>
                                                            <button type="button" @click="showAdditionalDetails(vehicleGroup,index)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                                                <i class="la la-info-circle"></i>
                                                            </button>
                                                        </td> -->
                                                        <td>
                                                            <button type="button" @click="showDeliveryDetail(vehicleGroup,index)" class="btn btn-outline-dark btn-elevate btn-icon btn-sm">
                                                                <i class="la la-calendar"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="vehicleRequirement[vehicleGroup].length > 0" class="kt-font-bold bg-light-gray-1" >
                                                        <td colspan="3">@{{ vehicleGroup }}</td>
                                                        <td>@{{ vehicleGroup =="CV" ? (computeCVQty) : (computeLCVQty) }}</td>
                                                        <td>@{{ vehicleGroup =="CV" ? formatPrice(computeCVPrice) : formatPrice(computeLCVPrice) }}</td>
                                                        <td>@{{ vehicleGroup =="CV" ? formatPrice(computeCVQty * computeCVPrice) : formatPrice(computeLCVQty * computeLCVPrice) }}</td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>

                                                <tfoot>
                                                    <tr class="bg-light-gray-2">
                                                        <th colspan="3">Grand Total</th>
                                                        <th>@{{ (computeCVQty + computeLCVQty) }}</th>
                                                        <th>@{{ formatPrice(computeCVPrice + computeLCVPrice) }}</th>
                                                        <th>@{{ formatPrice((computeCVQty * computeCVPrice) + (computeLCVQty * computeLCVPrice)) }}</th>
                                                        <th></th>
                                                    </tr>
                                                    
                                                </tfoot>
                                            </table>
                                        </div>
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
                                    <label class="col-3 col-form-label">Has competitor?</label>
                                    <div class="col-9">
                                        <div class="kt-radio-inline">
                                            <label class="kt-radio kt-radio--brand">
                                                <input type="radio" value="Y"  v-model="competitor_flag">Yes
                                                <span></span>
                                            </label>
                                            <label class="kt-radio kt-radio--brand">
                                                <input type="radio" value="N" v-model="competitor_flag">No
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" v-show="competitor_flag == 'N'">
                                    <label class="col-3 col-form-label">Reason</label>
                                    <div class="col-9">
                                        <input type="text" v-model.lazy="no_competitor_reason" class="form-control" placeholder="Kindly state your reason..." />
                                    </div>
                                </div>

                                <div class="form-group row" v-show="competitor_flag == 'Y'">

                                    <label class="col-form-label col-md-3">Attachment</label>
                                    <div class=" col-md-9">
                                        <div class="custom-file">
                                            <input type="file" @change="validateFileSize('competitor')" class="custom-file-input" ref="customFile2" name="competitor_attachments[]" id="competitor_attachments" multiple="true">
                                            <label class="custom-file-label" for="competitor_attachments">@{{ file_label2 }}</label>
                                            <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                                                <li v-for="(row,index) in competitor_attachments">
                                                    <a target="_blank" :href="baseUrl + '/' + row.directory + '/' + row.filename" download v-if="row.directory != null">@{{ row.orig_filename }}</a>
                                                    <span v-if="row.directory == null">@{{ row.orig_filename }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" v-show="competitor_flag == 'Y'">
                                    <div class="col-lg-4">
                                        <label>Brand</label>
                                        <div class="typeahead">
                                            <input 
                                                class="form-control" 
                                                type="text" dir="ltr" 
                                                placeholder="Competitor brand" 
                                                id="txt_comp_brand" 
                                                v-model="cur_competitor_brand" 
                                            />
                                        </div> 
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Model</label>
                                      <!--   <div class="input-group"> -->
                                            <div class="typeahead">
                                                <input 
                                                    class="form-control" 
                                                    type="text" 
                                                    dir="ltr" 
                                                    placeholder="Competitor Model" 
                                                    id="txt_comp_model" 
                                                    v-model="cur_competitor_model" 
                                                />
                                            </div> 
                                          <!--   <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" @click="addCompetitor">Add</button>
                                            </div> -->
                                       <!--  </div> -->
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Isuzu Model</label>
                                        <div class="input-group">
                                            <select class="form-control" v-model="competitor_model" id="sel_competitor_model">
                                                <optgroup v-for="(vehicleGroup,index) in Object.keys(vehicleRequirement)" :label="vehicleGroup" v-if="vehicleRequirement[vehicleGroup].length > 0">
                                                    <option 
                                                        v-for="(model,index) in vehicleRequirement[vehicleGroup]" 
                                                        :value="model.inventory_item_id" 
                                                        :data-model="model.model"
                                                        :data-color="model.color"
                                                    >@{{ model.model }} - @{{ model.color}}</option>
                                                </optgroup>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" @click="addCompetitor">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                 
                                <div class="row" v-if="competitor_flag == 'Y'">
                                    <div class="col-md-12">
                                        
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Brand</th>
                                                        <th>Model</th>
                                                        <th>Price</th>
                                                        <th>Isuzu Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(row,index) in competitors">
                                                        <td style="width:10%;">
                                                            <a href="#" @click.prevent="removeCompetitor(index)">
                                                                <i class="flaticon flaticon-delete kt-font-danger"></i>
                                                            </a>
                                                        </td>
                                                        <td style="width:30%;">@{{ row.brand }}</td>
                                                        <td style="width:20%;">@{{ row.model }}</td>
                                                        <td><input type="text" v-model.lazy="row.price" class="form-control form-control-sm"/></td>
                                                        <td>
                                                            @{{ row.ipc_model }}
                                                            <span class="kt-badge kt-badge--brand kt-badge--inline">@{{ row.ipc_color}}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--end: Form Wizard Step 3-->

                    <!--begin: Form Actions -->
                    <div class="kt-form__actions">
                        <button id="vue_submit" @click="callVueSubmitForm" v-show="false">Vue submit</button>
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


@include('projects/modal/mp_delivery_additional_details')

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

var Select2 = function(afiliateOptions,projectSourceOptions,organizationOptions,paymentTermOptions,salesPersonOptions){

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

    var initPaymentTerm = function(paymentTermOptions){
        $('#sel_payment_term').select2({
            placeholder: "Select a payment term",
            data: paymentTermOptions
        });
    }

    var affiliates = function(afiliateOptions){
        $('#sel_affiliates').select2({
            placeholder: "Select affiliates",
            data : afiliateOptions,
            allowClear: true
        });


        $('#sel_affiliates').on('select2:unselecting', function (e) {
                $("#sel_affiliates").trigger('change');//    alert('You clicked on X');
        });
    }

    var initSalesPersons = function(salesPersonOptions){
        $('#sel_sales_persons').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select a sales person'
            },
            data: salesPersonOptions
        });
    }

    return {
        init : function(afiliateOptions,projectSourceOptions,organizationOptions,paymentTermOptions,salesPersonOptions){
            initSelProjectSource(projectSourceOptions);
            intSelOrg(organizationOptions);
            initPaymentTerm(paymentTermOptions);
          //  initSelScope();
            affiliates(afiliateOptions);
            initSalesPersons(salesPersonOptions);
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

    Vue.directive('mask', {
        bind: function (el, binding) {
            var maskOpts = binding.value;
            maskOpts.showMaskOnHover = false;
            maskOpts.autoUnmask = true;
            maskOpts.clearIncomplete = true;
            Inputmask(maskOpts).mask(el);
        },
        unbind: function(el) {
            Inputmask.remove(el);
        }
    });

    var vm =  new Vue({
        el : "#app",
        data: {
            // option data
            projectSourceOptions: {!! json_encode($project_sources) !!},
            organizationOptions:  {!! json_encode($organizations) !!},
            customerOptions:      {!! json_encode($customer_options) !!},
            salesPersonOptions:   {!! json_encode($sales_persons) !!},
            fleetCategories:      {!! json_encode($fleet_categories) !!},
            baseUrl:              {!! json_encode($base_url) !!},
            competitor_model:     '',
            // step 1 - account details
            accountDetails : {
                customer_id:             null,
                selected_org_type:       2,
                selected_project_source: 4,
                others:                  null,
                bid_ref_no:              null,
                bid_docs_amount:         null,
                pre_bid_sched:           null,
                bid_date_sched:          null,
                bidding_venue:           null,
                approved_budget_cost:    null,
                account_name:            null,
                tin:                     null,
                address:                 null,
                establishment_date:      null,
                products:                null,
                company_overview:        null,
                business_style:          null,
                affiliates:              [],
                fleet_category : -1
            },
            // step 2 - contact information
            // temp variables
            selected_sales_person:   -1,
            contactNumber:           null,
            contactDetails : {
                custContacts:            [],
                email_address:           null,
                website_url:             null,
                facebook_url:            null,
                contactPersons:          [],
                salesPersons:            []
            },
            // step 3 - requirement
            // temp variables
            vehicle_details_flag:    true,
            vehicle_models:           {!! json_encode($vehicle_models) !!},
            vehicle_types:           {!! json_encode($vehicle_types) !!},
            vehicle_lead_times:           {!! json_encode($vehicle_lead_times) !!},
            selected_row_index:      null,
            selected_vehicle_group : '',
            selected_model:          -1,
            vehicleColors:           [],
            selected_color:          -1,
            // needed to to submit in form
            //selected_vehicle_type:   null,
            vehicleRequirement:      {
                'LCV' : [],
                'CV' : [] 
            },
            // temporary variables 
            cur_body_builder:        null,
            cur_addtl_items:         null,
            cur_rear_body:           null,
            cur_delivery_sched:      [],
            cur_model:               null,
            cur_color:               null,
            cur_quantity:            null,
            cur_competitor_brand:    null,
            cur_competitor_model:    null,
            cur_variant : null,
            cur_lead_time_desc : null,
            // step 4 - competitors
            competitors:             [],
            no_competitor_reason:    "",
            competitor_flag:         null,
            attachments:             [],
            competitor_attachments:  [],
            file_label               : 'Choose file',
            file_label2              : 'Choose file',
            is_exist                 : false
        },
        methods : {
            callVueSubmitForm(){
                var self = this;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                    if (result.value) {
                          
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                    
                        // update values of affiliates select2 since remove event is not firing
                        self.accountDetails.affiliates = $('#sel_affiliates').val();

                        axios.post('/save-project', {
                            accountDetails : self.accountDetails,
                            contactDetails : self.contactDetails,
                            requirement : self.vehicleRequirement,
                            competitors : self.competitors,
                            no_competitor_reason : self.no_competitor_reason,
                            competitor_flag : self.competitor_flag
                        })
                        .then(function (response) {
                            self.processFileUpload(
                                response.data.customer_id,
                                response.data.project_id
                            );
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });  
            },
            processFileUpload(customer_id,project_id){
                let data = new FormData();
                var self = this;
                data.append('customer_id',customer_id);
                data.append('project_id',project_id);

                $.each($("#attachment")[0].files, function(i, file) {
                    data.append('attachment[]', file);
                });

                $.each($("#competitor_attachments")[0].files, function(i, file) {
                    data.append('competitor_attachments[]', file);
                });

                axios.post('/upload-project-attachment',data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    KTApp.unblockPage();
                    if(response.data.status == "success"){
                        Swal.fire({
                            type: 'success',
                            title: 'Project has been created!',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose : function(){
                                var link = self.baseUrl + '/project-overview/view/' + project_id;
                                window.location.href = link;
                            }
                        });
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Unexpected error encountered during the transaction, please contact the system administrator.',
                            showConfirmButton: true
                        });
                    }
                });
            },
            validateFileSize(attachment_type){
                var self = this;
                var total_size = 0;
                var total_files = 0;
                
                self.attachments = [];
                self.competitor_attachments = [];

                if(attachment_type == "customer"){

                    $.each($("#attachment")[0].files, function(i, file) {
                        total_size += file.size;  
                        self.attachments.push({
                            directory : null,
                            filename : file.name,
                            orig_filename : file.name
                        });
                        total_files++;
                    });
                }
                else if(attachment_type == "competitor"){
                    $.each($("#competitor_attachments")[0].files, function(i, file) {
                        total_size += file.size;  
                        self.competitor_attachments.push({
                            directory : null,
                            filename : file.name,
                            orig_filename : file.name
                        });
                        total_files++;
                    });
                }
                

                var total_size_mb = total_size / 1024 / 1024;
                if(total_size_mb >= 10){
                    Swal.fire({
                        type: 'error',
                        title: 'Attachment must be less than 10mb.',
                        showConfirmButton: true
                    });

                    if(attachment_type == "customer"){
                        $("#attachment").val("");
                        self.attachments = [];
                    }
                    else if(attachment_type == "competitor"){
                        $("#competitor_attachments").val("");
                        self.competitor_attachments = [];
                    }
                    
                }
                else {
                   if(attachment_type == "customer"){
                        self.file_label = total_files + " file" + (total_files > 1 ? "s" : "") + " selected" ;
                   }
                   else if(attachment_type == "competitor"){
                        self.file_label2 = total_files + " file" + (total_files > 1 ? "s" : "") + " selected" ;
                   }
                }
            },
            addContactRow(){
                this.contactDetails.contactPersons.push(
                    {
                        name : "",
                        position : "",
                        department : "",
                        contact_number : "",
                        email : ""
                    }
                );
            },
            showDeliveryDetail(vehicle_group,index){
                // delivery details
                this.selected_row_index     = index;
                this.selected_vehicle_group = vehicle_group;
                this.cur_model              = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].model;
                this.cur_color              = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].color;
                this.cur_quantity           = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].quantity;
                this.cur_delivery_sched     = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].delivery_schedule;
                this.cur_variant            = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].variant;
                
                // additional details
                this.cur_rear_body          = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].rear_body_type;
                this.cur_addtl_items        = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].additional_details;
                this.cur_body_builder       = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].body_builder;

                let vehicle_lead_time = this.vehicle_lead_times[this.cur_variant];  
                this.cur_lead_time_desc = vehicle_lead_time == 1 ? vehicle_lead_time + " month" : vehicle_lead_time + " months";
     

                if(this.cur_quantity > 0){
                    $("#deliveryScheduleModal").modal('show');
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: 'Please enter value for the quantity',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            /*showAdditionalDetails(vehicle_group,index){
                this.selected_row_index     = index;
                this.selected_vehicle_group = vehicle_group;
                this.cur_rear_body          = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].rear_body_type;
                this.cur_addtl_items        = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].additional_details;
                this.cur_body_builder       = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].body_builder;
                $("#additionalDetailsModal").modal('show');
            },*/
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
                });
            },
            addCustContact(){
                if(this.contactNumber != "" && this.contactNumber != null){
                    this.contactDetails.custContacts.push({
                        contact_number : this.contactNumber
                    });
                    this.contactNumber = null;
                }
                else {
                   Swal.fire({
                        type: 'error',
                        title: 'Please enter value on the contact no.',
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                }
            },
            deleteContact(index){
                this.contactDetails.custContacts.splice(index,1);
            },
            removeContactPerson(index){
                this.contactDetails.contactPersons.splice(index,1);
            },
            removeSalesPersons(index){
                this.contactDetails.salesPersons.splice(index,1);
            },
            addSalesPerson(){
                let self = this;
                if(this.selected_sales_person == null || this.selected_sales_person == -1){
                    Swal.fire({
                        type: 'error',
                        title: 'Please select a sales person.',
                        showConfirmButton: true,
                        timer: 1500
                    }); 
                }
                else {
                 
                    var isExist = self.contactDetails.salesPersons.filter(function(elem){
                        if(elem.sales_person_id === self.selected_sales_person) {
                            return elem.sales_person_id;
                        }
                    });
                    if(isExist == 0 ){
                        $('#se_wrapper').block({ 
                            message: '<h1>Processing</h1>'
                        }); 
                        axios.get('/get-sales-person-detail/' + this.selected_sales_person)
                            .then(function (response) {
                                var data = response.data.data;
                                // handle success
                                self.contactDetails.salesPersons.push({
                                    sales_person_id : self.selected_sales_person,
                                    position_title : data.description,
                                    name : data.fname + " " + data.lname,
                                    mobile_no : data.mobile_1,
                                    email : data.email_1
                                });
                                $('#se_wrapper').unblock(); 
                                self.selected_sales_person = -1;
                            })
                            .catch(function (error) {
                                // handle error
                            console.log(error);
                            })
                            .finally(function () {
                                // always executed
                            });
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Sales person has been added already.',
                            showConfirmButton: true,
                            timer: 1500
                        }); 
                    }
                }
            },
            
            addVehicle(){
                let self = this;
                let color = $("#sel_vehicle_colors option:selected").text();
                var vehicle_type = $("#sel_vehicle_models option:selected").data('vehicle_type');
                var variant = $("#sel_vehicle_models option:selected").data('variant');

                if(self.selected_model != -1 && self.selected_color != -1){

                    var isExist = self.vehicleRequirement[vehicle_type].filter(function(elem){
                        if(elem.inventory_item_id === self.selected_color) {
                            return elem.inventory_item_id;
                        }
                    });

                    if(isExist == 0){
                        var newObj = {
                                inventory_item_id : self.selected_color,
                                variant : variant,
                                model : self.selected_model,
                                color : color,
                                quantity : 0,
                                suggested_price : 0,
                                body_builder : null,
                                rear_body_type : null,
                                additional_details : null,
                                delivery_schedule : []
                        }
                        self.vehicleRequirement[vehicle_type].push(newObj);
                
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: 'Model already exists.',
                            showConfirmButton: true,
                            timer: 1500
                        });
                    }
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: 'You must select a model and a color.',
                        showConfirmButton: true,
                        timer: 1500
                    });
                }
            },
            removeVehicle(vehicle_group,index){
                this.vehicleRequirement[vehicle_group].splice(index,1);
            },
            addDeliverySched(){
                let vehicle_lead_time = this.vehicle_lead_times[this.cur_variant];
                let min_delivery_date =  moment().add(vehicle_lead_time, 'months').format('YYYY-MM-DD');
                let default_delivery_date = moment().add(vehicle_lead_time, 'months').format('YYYY-MM-DD')
                
                this.cur_delivery_sched.push({
                    quantity : 0,
                    delivery_date : default_delivery_date,
                    min_delivery_date : min_delivery_date
                });
            },
            deleteDeliveryDate(index){
                this.cur_delivery_sched.splice(index,1);
            },
            saveDeliverySched(){
                var delivery_sched = this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].delivery_schedule;
                var is_error = 0;
    
                if(this.selected_vehicle_group == "CV"){
                    if(this.cur_rear_body == null || this.cur_body_builder == null){
                        Swal.fire({
                            type: 'error',
                            title: "Body builder name and Rear body type is required for CV models",
                            showConfirmButton: true,
                            timer: 1500
                        });
                        is_error++;
                        return false;
                    }
                }

                for(data in delivery_sched){
                    if(delivery_sched[data].delivery_date == null || delivery_sched[data].quantity == null || delivery_sched[data].quantity == 0){
                        is_error++;
                    }
                }
                if(is_error <= 0){
                    if(this.computeDeliveryQuantity == this.cur_quantity){
                        this.vehicleRequirement[this.selected_vehicle_group][this.selected_row_index].delivery_schedule = this.cur_delivery_sched;
                        $("#deliveryScheduleModal").modal('hide');
                    }
                    else {
                        Swal.fire({
                            type: 'error',
                            title: "Total delivery quantity must be equal to the requirement's quantity.",
                            showConfirmButton: true,
                            timer: 1500
                        });
                    }
                }
                else {

                    Swal.fire({
                        type: 'error',
                        title: "Please enter value for delivery date and quantity.",
                        showConfirmButton: true,
                        timer: 1500
                    });
                }
            },
            addCompetitor(){
                var self = this;
                if(
                    self.cur_competitor_brand != "" && 
                    self.cur_competitor_brand != null && 
                    self.cur_competitor_model != "" &&
                    self.cur_competitor_model != null
                ){

                    var ipc_model = $("#sel_competitor_model option:selected").data('model'); 
                    var ipc_color = $("#sel_competitor_model option:selected").data('color');

                    self.competitors.push({
                        brand : self.cur_competitor_brand, 
                        model : self.cur_competitor_model,
                        price : 0,
                        ipc_model : ipc_model,
                        ipc_color : ipc_color,
                        ipc_item_id : self.competitor_model
                    });

                    self.cur_competitor_brand = null;
                    self.cur_competitor_model = null;
                }
                else {
                    Swal.fire({
                        type: 'error',
                        title: 'You must enter the brand and model.',
                        showConfirmButton: true,
                        timer: 1500
                    });
                }
            },
            removeCompetitor(index){
                this.competitors.splice(index,1);
            },
            formatPrice(value) {
                return (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            }
        },
        created: function () {
      
        },
        mounted : function () {


            var self = this;
        
            Select2.init(
                this.customerOptions, 
                this.projectSourceOptions, 
                this.organizationOptions,
                this.paymentTermsOptions,
                this.salesPersonOptions
            );
            
            $("#sel_vehicle_colors,#sel_vehicle_models").select2();
            $("#txt_tin").on("change",function(){
                self.accountDetails.tin = $(this).val();
            });
            $("#deliveryScheduleModal").on("hidden.bs.modal", this.saveDeliverySched);

            // Business Style typeahead
            $('#txt_business_style').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                limit: 12,
                async: true,
                source: function (query, processSync, processAsync) {
                    //processSync(['Searching...']);
                    return $.ajax({
                        url: "{{ url('/ajax_get_scope') }}", 
                        type: 'GET',
                        data: {query: $.trim(query)},
                        dataType: 'json',
                        success: function (json) {
                            // in this example, json is simply an array of strings
                            return processAsync(json);
                        }
                    });
                }
            }).on('typeahead:selected', function(evt, item) {
                self.accountDetails.business_style = item;
            });

            // Customer name typeahead
            $('#txt_account_name').typeahead({
                hint: true,
                highlight: true,
                minLength: 3
            },
            {
                limit: 5,
                async: true,
                source: function (query, processSync, processAsync) {
                   // processSync(['Searching...']);
                    return $.ajax({
                        url: "{{ url('/ajax-get-customers') }}", 
                        type: 'GET',
                        data: {query: $.trim(query)},
                        dataType: 'json',
                        success: function (json) {
                            // in this example, json is simply an array of strings
                            return processAsync(json);
                        }
                    });
                }
            }).on('typeahead:selected', function(evt, item) {
                // do what you want with the item here
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });
             
                axios.get('/ajax-get-customer-data/' + item)
                    .then(function (response) {
                     
                        var data = response.data.details;
                        self.attachments = response.data.attachments;
            
                        self.accountDetails.affiliates = response.data.affiliates;
                        self.accountDetails.customer_id = data.customer_id;
                        self.accountDetails.selected_org_type = data.organization_type_id;

                        self.accountDetails.account_name = data.customer_name;
                        self.accountDetails.tin = data.tin;
                        $("#txt_tin").val(self.accountDetails.tin);
                        self.accountDetails.address = data.address;
                        self.accountDetails.business_style = data.business_style;
                        self.accountDetails.company_overview = data.company_overview;
            
                        self.accountDetails.products = data.products;
                        self.accountDetails.establishment_date = data.establishment_date;

                        KTApp.unblockPage();
                    })
                    .catch(function (error) {
                        // handle error
                        KTApp.unblockPage();
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                        KTApp.unblockPage();
                    });                        
            }); 

            $('#txt_comp_brand').typeahead({
                hint: true,
                highlight: true,
                minLength: 3
            },
            {
                limit: 10,
                async: true,
                source: function (query, processSync, processAsync) {
                   // processSync(['Searching...']);
                    return $.ajax({
                        url: "{{ url('/ajax-get-competitor-brands') }}", 
                        type: 'GET',
                        data: {query: $.trim(query)},
                        dataType: 'json',
                        success: function (json) {
                            // in this example, json is simply an array of strings
                            return processAsync(json);
                        }
                    });
                }
            });

            $('#txt_comp_model').typeahead({
                hint: true,
                highlight: true,
                minLength: 3
            },
            {
                limit: 10,
                async: true,
                source: function (query, processSync, processAsync) {
                   // processSync(['Searching...']);
                    return $.ajax({
                        url: "{{ url('/ajax-get-competitor-models') }}", 
                        type: 'GET',
                        data: {
                            query: $.trim(query),
                            brand : $("#txt_comp_brand").val()
                        },
                        dataType: 'json',
                        success: function (json) {
                            // in this example, json is simply an array of strings
                            return processAsync(json);
                        }
                    });
                }
            });


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

                        if(wizardObj.currentStep == 2){
                            if(self.contactDetails.custContacts.length <= 0){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Please enter alteast one contact number.',
                                    showConfirmButton: true,
                                    timer: 1500
                                });   
                                wizardObj.stop();
                                return false;
                            }
                            if(self.contactDetails.contactPersons.length <= 0){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Please enter alteast one contact person.',
                                    showConfirmButton: true,
                                    timer: 1500
                                });   
                                wizardObj.stop();
                                return false;
                            }
                            if(self.contactDetails.salesPersons.length <= 0){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Please select atleast one sales person.',
                                    showConfirmButton: true,
                                    timer: 1500
                                });   
                                wizardObj.stop();
                                return false;
                            }
                        }
                        else if (wizardObj.currentStep == 3){
                            if( (self.computeCVQty + self.computeLCVQty) < 3)  {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Requirement must have quantities 3 or above.',
                                    showConfirmButton: true,
                                    timer: 1500
                                });   
                                wizardObj.stop();
                                return false;
                            }
                            else {
                                var lcv_total = 0;
                                var cv_total = 0;
                                for(model of self.vehicleRequirement['LCV']){
                                    lcv_total += model.delivery_schedule.reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
                                }
                                for(model of self.vehicleRequirement['CV']){
                                    cv_total += model.delivery_schedule.reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
                                }

                                if( (lcv_total + cv_total) != (self.computeLCVQty + self.computeCVQty) ){
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Please check values of delivery schedule',
                                        showConfirmButton: true,
                                        timer: 1500
                                    });   
                                    wizardObj.stop();
                                    return false;
                                }
                            }
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
                            account_name: {
                                required: true 
                            },
                            tin: {
                                required: true 
                            },
                            establishment_date: {
                                required: true 
                            },
                            products: {
                                required: true 
                            },
                            address: {
                                required: true 
                            },
                            
                            bid_ref_no : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;  
                                }
                            },
                            bid_docs_amount : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;  
                                }
                            },
                            pre_bid_sched : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;   
                                }
                            },
                            business_style: {
                                required: true
                            }, 
                            bid_date_sched : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;    
                                }
                            },
                            bidding_venue : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;   
                                }
                            },
                            approved_budget_cost : {
                                required: function(element){
                                    return $("#sel_org_type").val() == 1;   
                                }
                            },

                            // Step 2
                            email_address: {
                                required: true 
                            },
                            website_url: {
                                required: true 
                            },
                            facebook_url: {
                                required: true 
                            }
                        },
                       
                        // Display error  
                        invalidHandler: function(event, validator) {     
                            KTUtil.scrollTop();
                            swal.fire({
                                "title": "", 
                                "text": "There are some errors in your submission. Please correct them.", 
                                "type": "error",
                                "confirmButtonClass": "btn btn-primary"
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

                        if(self.competitor_flag == null)  {

                            Swal.fire({
                                type: 'error',
                                title: 'Please select competitor',
                                showConfirmButton: true,
                                timer: 1500
                            });   
                            wizardObj.stop();
                            return false;
                        }
                        else {
                            if(self.competitor_flag == 'Y'){
                                if(self.competitors.length <= 0){
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Please enter atleast one competitor',
                                        showConfirmButton: true,
                                        timer: 1500
                                    });   
                                    wizardObj.stop();
                                    return false;   
                                }
                                else {
                                    e.preventDefault();
                                    if (validator.form()) {
                                        $("#vue_submit").click();
                                    } 
                                }
                            }
                            else if(self.competitor_flag == 'N'){
                                if(self.no_competitor_reason == ""){
                                     Swal.fire({
                                        type: 'error',
                                        title: 'Please state your reason for not having a competitor',
                                        showConfirmButton: true,
                                        timer: 1500
                                    });   
                                    wizardObj.stop();
                                    return false;  
                                }
                                else {
                                    e.preventDefault();
                                    if (validator.form()) {
                                        $("#vue_submit").click();
                                    } 

                                }
                            }
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

            KTWizard1.init();
        },
        watch: {
            selected_model : function(val){
                let self = this;
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                });
                axios.get('/get-vehicle-colors/' + val)
                    .then(function (response) {
                        self.vehicleColors = response.data;
                        $("#sel_vehicle_colors").select2();
                        self.selected_color = -1;
                        KTApp.unblockPage();
                    })
                    .catch(function (error) {
                        Swal.fire({
                            type: 'error',
                            title: 'Unexpected error occurred, could not add this model.',
                            showConfirmButton: true,
                            timer: 1500
                        });
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            },
            cur_body_builder : function(val){
                let self = this;
                self.vehicleRequirement[self.selected_vehicle_group][self.selected_row_index].body_builder = val;
            },
            cur_rear_body : function(val){
                let self = this;
                self.vehicleRequirement[self.selected_vehicle_group][self.selected_row_index].rear_body_type = val;
            },
            cur_addtl_items : function(val){
                let self = this;
                self.vehicleRequirement[self.selected_vehicle_group][self.selected_row_index].additional_details = val;
            }
        },
        computed : {
            computeCVQty : function(){
                return this.vehicleRequirement['CV'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            computeLCVQty : function(){
                return this.vehicleRequirement['LCV'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            },
            computeCVPrice : function(){
                return this.vehicleRequirement['CV'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.suggested_price),0);
            },
            computeLCVPrice : function(){
                return this.vehicleRequirement['LCV'].reduce((acc,item) => parseFloat(acc) + parseFloat(item.suggested_price),0);
            },
            computeDeliveryQuantity : function(){
                return this.cur_delivery_sched.reduce((acc,item) => parseFloat(acc) + parseFloat(item.quantity),0);
            }
        }
    });

  
</script>
@endpush