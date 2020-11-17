  <div class="row">
                    <div class="col-md-6">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">
                                Project Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Project No.</span>
                                    <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ projectDetails.project_id }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Dealer</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">
                                    @{{ projectDetails.dealer_name }} - @{{ projectDetails.dealer_account}}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Fleet Account Name</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.fleet_account_name }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Oracle Customer</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.oracle_customer }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Fleet Category</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ projectDetails.fleet_category_name }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Project Source</span>
                                    <span class="col-md-8">@{{ projectDetails.project_source }}</span>
                                </div>
                               
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Date Submitted</span>
                                    <span class="col-md-8">@{{ projectDetails.date_created }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Submitted By</span>
                                    <span class="col-md-8">@{{ projectDetails.created_by }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Status</span>
                                    <span class="col-md-8">
                                        <span :class="status_colors[projectDetails.status_name]">@{{ projectDetails.status_name }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card" v-if="projectDetails.bid_ref_no">
                            <div class="card-header">
                                Bidding Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bidding Ref No.</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_ref_no }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bid Docs Amount</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_docs_amount }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Pre-bid Schedule</span>
                                    <span class="col-md-8">@{{ projectDetails.pre_bid_sched }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bid Date Sched</span>
                                    <span class="col-md-8">@{{ projectDetails.bid_date_sched }}</span>
                                </div> 
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Bidding Venue</span>
                                    <span class="col-md-8">@{{ projectDetails.bidding_venue }}</span>
                                </div> 
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Approved Budget Cost</span>
                                    <span class="col-md-8">@{{ projectDetails.approved_budget_cost }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-header">
                                Customer Details
                            </div>
                            <div class="card-body">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Organization Type</span>
                                    <span class="col-md-8">@{{ customerDetails.org_type_name }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">TIN</span>
                                    <span class="col-md-8 kt-font-bold kt-font-primary">@{{ customerDetails.tin }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Address</span>
                                    <span class="col-md-8">@{{ customerDetails.address }}</span>
                                </div>
                                <div class="row kt-margin-b-5" v-if="attachments.length > 0">
                                    <span class="col-md-4 kt-font-bold">Attachment</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in attachments">
                                                <a :href="base_url + '/' + row.symlink_dir  +row.filename " download>@{{ row.orig_filename }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Business Style</span>
                                    <span class="col-md-8">@{{ customerDetails.business_style }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Date of Establishment</span>
                                    <span class="col-md-8">@{{ customerDetails.establishment_date }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Affiliates</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in affiliates">
                                                <a href="#">@{{ row.customer_name }}</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Products</span>
                                    <span class="col-md-8">@{{ customerDetails.products }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Company Overview</span>
                                    <span class="col-md-8">@{{ customerDetails.company_overview }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 