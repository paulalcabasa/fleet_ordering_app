<div class="card kt-margin-b-10">
                    <div class="card-header">
                        Customer Contact Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Contact No.</span>
                                    <span class="col-md-8">
                                        <ul style="list-style:none;padding:0;">
                                            <li v-for="(row,index) in contacts">@{{ row.contact_number }}</li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Email</span>
                                    <span class="col-md-8">@{{ projectDetails.email}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Website</span>
                                    <span class="col-md-8">@{{ projectDetails.website_url }}</span>
                                </div>
                                <div class="row kt-margin-b-5">
                                    <span class="col-md-4 kt-font-bold">Facebook</span>
                                    <span class="col-md-8">@{{ projectDetails.facebook_url }}</span>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            
                <div class="card kt-margin-b-10">
                    <div class="card-header">
                        Contact Persons
                    </div>
                    <div class="card-body">
                         <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in contactPersons">
                                    <td>@{{ row.name }}</td>
                                    <td>@{{ row.position_title }}</td>
                                    <td>@{{ row.department }}</td>
                                    <td>@{{ row.contact_number }}</td>
                                    <td>@{{ row.email_address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
             
                <div class="card">
                    <div class="card-header">Dealer Sales Executives</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>  
                                    <th>Mobile No.</th>  
                                    <th>Email</th>  
                                    <th></th>  
                                </tr>
                            </thead> 
                            <tbody>
                                <tr v-for="(row, index) in salesPersons">
                                    <td>@{{ row.name }}</td>
                                    <td>@{{ row.position }}</td> 
                                    <td>@{{ row.mobile_no }}</td> 
                                    <td>@{{ row.email_address }}</td> 
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>