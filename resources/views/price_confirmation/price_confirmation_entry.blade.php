@extends('_layouts.metronic')

@section('page-title', 'Price Confirmation')

@section('content')

<div id="app">

<div class="row">
    
    <div class="col-md-8">
        <div class="kt-portlet kt-portlet--last  kt-portlet--responsive-mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Customer</h3>
                </div>
               
            </div>
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <label>Account Name</label>
                    <select class="form-control" id="sel_customer">
                        <option value=""></option>
                        <option v-for="(row,index) in customers" 
                            :value="row.customer_id" 
                            :data-tin="row.tin"
                            :data-address="row.address"
                            :data-org_type="row.org_type_name"
                        >@{{ row.customer_name }}</option>
                    </select>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="row">
                    <div class="col-lg-6 kt-align-left">
                        <button type="button" class="btn btn-brand" @click="getProjects()" v-show="customerDetails.customerId">Search</button>
                    </div>
                    <div class="col-lg-6 kt-align-right">
                        <button type="button" @click="createPriceConfirmation()" class="btn btn-success" v-show="projects.length > 0">Create</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="col-md-4" v-if="customerDetails.customerId">
        <div class="kt-portlet kt-portlet--last  kt-portlet--responsive-mobile">
            <div class="kt-portlet__head" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Customer Details</h3>
                </div>
            </div>
            <div class="kt-portlet__body"> 
                <div class="details-item">
                    <span class="details-label">Organization Type</span>
                    <span class="details-subtext">@{{ customerDetails.orgType }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Customer ID</span>
                    <span class="details-subtext">@{{ customerDetails.customerId }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">TIN</span>
                    <span class="details-subtext">@{{ customerDetails.tin }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Address</span>
                    <span>@{{ customerDetails.address }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info" role="alert" v-if="projects.length == 0 && search_flag">
    <div class="alert-text">
        <h4 class="alert-heading">No results found!</h4>
        <p>It seems you have already created an FPC for this customer or not yet approved the project.</p>
<!--         <hr>
        <p class="mb-0">Kind</p> -->
    </div>
</div>


<div class="row">
    <div class="col-md-8">

        
        <div class="alert alert-info fade show" v-if="activeFpc.length > 0" role="alert" v-for="row in activeFpc">
            <div class="alert-icon"><i class="flaticon-info"></i></div>
            <div class="alert-text">An active FPC with Ref No. <strong>@{{ row.fpc_id }}</strong> for <strong>@{{ row.customer_name}}</strong> created by <strong>@{{ row.created_by }}</strong> last <strong>@{{ row.date_created}} exists</strong>, would you like to add these projects instead? Mark the desired projects as <i>checked</i> then click <i>Add</i>. <br/><a :href="'price-confirmation-details/' + row.fpc_id" target="_blank" class="text-light">Click here to view FPC details.</a></div>
            <div class="alert-close">
                <button type="button" class="btn btn-success btn-sm">
                    Add
                </button>
            </div>
        </div>

        <div class="kt-portlet kt-portlet--last  kt-portlet--responsive-mobile" v-if="projects.length > 0">
            <div class="kt-portlet__head" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Fleet Projects</h3>
                </div>
            </div>
            <div class="kt-portlet__body"> 
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>Project No</th>
                            <th>Dealer</th>
                            <th>Date Requested</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <tr v-for="(row,index) in projects">
                                <td>@{{ row.project_id }}</td>
                                <td>@{{ row.dealer_name }} <span class="kt-badge kt-badge--brand kt-badge--inline">@{{ row.dealer_account }}</span> </td>
                                <td>@{{ row.date_created }}</td>
                                <td><span :class="status_colors[row.status_name]">@{{ row.status_name }}</span></td>
                                <td nowrap>
                                    <a  target="_blank" :href="base_url + '/' + 'project-overview/view/' + row.project_id" class="btn btn-primary  btn-sm btn-icon btn-circle"><i class="la la-eye"></i></a>
                                    <a href="#" class="btn btn-danger  btn-sm btn-icon btn-circle" @click="removeProject(index)"><i class="la la-trash"></i></a> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  

    <div class="col-md-4" v-if="conflicts.length > 0">
        <div class="kt-portlet kt-portlet--last  kt-portlet--responsive-mobile" v-if="projects.length > 0">
            <div class="kt-portlet__head" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Conflicting Models</h3>
                </div>
            </div>
            <div class="kt-portlet__body"> 
                <ul v-for="row in conflicts" style="list-style-type:none;padding:0;margin:0;">
                    <li><i class="flaticon2-right-arrow"></i> @{{ row.sales_model }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>


</div>

@stop

@push('scripts')
<script>


</script>
<script>

    var vm =  new Vue({
        el : "#app",
        data: {
            customers : {!! json_encode($customers) !!},
            base_url : {!! json_encode($base_url) !!},
            status_colors : {!! json_encode($status_colors) !!},
            customerDetails : {
                tin : '',
                address : '',
                customerId : '',
                orgType : ''
            },
            projects : [],
            conflicts : [],
            activeFpc : [],
            search_flag :false
        },
        methods : {
            createPriceConfirmation(){
                var self = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This process will create an FPC.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                        axios.post('/save-fpc', {
                            customerDetails : self.customerDetails,
                            projects : self.projects
                        })
                        .then(function (response) {
                            Swal.fire({
                                type: 'success',
                                title: 'Price confirmation has been saved!',
                                showConfirmButton: false,
                                timer: 1500,
                                onClose : function(){
                                    window.location.href = self.base_url + "/price-confirmation-details/"  + response.data.fpc_id;
                                }
                            });
                            KTApp.unblockPage();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                });

            },
            removeProject(index){
                var self = this;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.value) {
                        self.projects.splice(index,1);
                    }
                });
            },
            getProjects(){
                let self = this;
               /*  KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: 'Please wait...'
                }); */

                axios.get('fpc/projects/' + self.customerDetails.customerId)
                    .then(function (response) {
                        console.log(response.data);
                        self.projects = response.data.projects;
                        self.conflicts = response.data.conflicts;
                        self.activeFpc = response.data.activeFpc;
                        self.search_flag = true;
                     //   KTApp.unblockPage();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            }
        },
        created: function () {
            // `this` points to the vm instance
            
        },
        mounted : function () {
            var self = this;
            $('#sel_customer').select2({
                placeholder: "Select a customer"
            }).on('change',function(){
                self.customerDetails.customerId = $("#sel_customer").val();
                self.customerDetails.tin = $("#sel_customer option:selected").data('tin');
                self.customerDetails.address = $("#sel_customer option:selected").data('address');
                self.customerDetails.orgType = $("#sel_customer option:selected").data('org_type');
            });
        }
    });
</script>
@endpush