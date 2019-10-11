<div class="modal fade" data-backdrop="static" data-keyboard="false" id="priceConfirmationModal" style="z-index:1050" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90% !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-5">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">Item Detail</div>
                            <div class="card-body" style="font-size:90%;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="details-item">
                                            <span class="details-label">Project No.</span>
                                            <span class="details-subtext">@{{ curModel.project_id }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Account Name</span>
                                            <span class="details-subtext">@{{ customer_details.customer_name}}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Dealer</span>
                                            <span class="details-subtext">@{{ curDealerAccount }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="details-item">
                                            <span class="details-label">Model</span>
                                            <span class="details-subtext">@{{ curModel.sales_model }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Quantity</span>
                                            <span class="details-subtext">@{{ curModel.quantity }}</span>
                                        </div>
                                        <div class="details-item">
                                            <span class="details-label">Suggested Price</span>
                                            <span class="details-subtext">@{{ formatPrice(curModel.suggested_price) }}</span>
                                        </div> 

                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Other Items</div>
                            <div class="card-body">
                                <!-- Form for entering freebies -->
                                <div class="table-responsive">
                                    <table class="table table-condensed" style="font-size:90%;" v-if="editable">
                                        <thead>
                                            <th></th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Cost to</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(freebie, index) in curFreebies" v-show="freebie.deleted != 'Y'">
                                                <td>
                                                    <a href="#" @click.prevent="deleteRow(freebie,index)">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                                <td v-if="freebie.hasOwnProperty('freebie_id')">
                                                    <input type="text" size="5" disabled="" class="form-control form-control-sm" :value="freebie.description"/>
                                                </td>
                                                <td v-if="!freebie.hasOwnProperty('freebie_id')">
                                                    <input type="text" size="5" class="form-control form-control-sm" v-model.lazy="freebie.description"/>
                                                </td>
                                                <td>
                                                    <input type="text" size="5" class="form-control form-control-sm" v-model="freebie.amount" />
                                                </td>
                                                <td>
                                                    <select class="form-control form-control-sm" v-model="freebie.cost_to">
                                                        <option value="6">Dealer</option>
                                                        <option value="5">IPC</option>
                                                    </select>
                                                </td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End for form for entering freebies -->
                                <div class="table-responsive">
                                <!-- table for viewing only freebies -->
                                    <table class="table table-condensed" style="font-size:90%;" v-if="!editable">
                                        <thead>
                                            <th>No.</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Cost To</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(freebie, index) in curFreebies" v-show="freebie.deleted != 'Y'">
                                                <td>@{{ index + 1 }}</td>
                                                <td>@{{ freebie.description }}</td>
                                                <td>@{{ formatPrice(freebie.amount) }}</td>
                                                <td>@{{ freebie.owner_name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- table for viewing only freebies -->
                            </div>
                            <div class="card-footer" v-if="editable">
                                <button type="button" class="btn btn-primary btn-sm"  @click="addRow()">Add</button>
                            </div>
                        </div>          
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">Pricing</div>
                            <div class="card-body">

                                <!-- form for entering pricing details -->
                                <form class="form-horizontal" v-if="editable">
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Price List</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" v-model="selected_pricelist" v-select style="width:100%;">
                                                <option value="">Select price list</option>
                                                <option v-for="(row,index) in pricelist_headers" 
                                                    :value="row.pricelist_header_id" 
                                                >@{{ row.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">SRP</label>
                                        <div class="col-lg-9">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm" 
                                                v-model="curModel.suggested_retail_price"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">WSP</label>
                                        <div class="col-lg-9">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm" 
                                                v-model="curModel.wholesale_price"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Fleet Price</label>
                                        <div class="col-lg-9">
                                            <input type="text" v-model="curModel.fleet_price" class="form-control form-control-sm" />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Dealer's Margin</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                
                                                <div class="col-md-7">
                                                    <input type="text" disabled="" class="form-control form-control-sm" :value="formatPrice(calculateMargin)" />
                                                </div> 
                                                <div class="col-md-5">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" class="form-control" v-model="curModel.dealers_margin" aria-describedby="basic-addon2">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">3 Yrs LTO Registration</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-sm" v-model="curModel.lto_registration" />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Freebies</label>
                                        <div class="col-lg-9">
                                            <input type="text" :value="formatPrice(sumFreebies)" class="form-control form-control-sm" disabled="" />
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Cost</label>
                                        <div class="col-lg-9">
                                            <input type="text" :value="formatPrice(calculateCost)" class="form-control form-control-sm" disabled="" />
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Promo Title</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-sm" v-model="curModel.promo_title"  />
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Promo</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-sm" v-model="curModel.promo" />
                                        </div>
                                    </div>
                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Net Cost</label>
                                        <div class="col-lg-9">
                                            <input type="text" :value="formatPrice(calculateNetCost)" class="form-control form-control-sm" disabled="" />
                                        </div>
                                    </div>

                                    

                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Subsidy per unit</label>
                                        <div class="col-lg-9">
                                            <input type="text" :value="formatPrice(calculateSubsidy)" class="form-control form-control-sm" disabled="" />
                                        </div>
                                    </div>

                                    <div class="form-group row" style="margin-bottom:.5em !important;">
                                        <label class="col-lg-3 col-form-label">Total IPC Subsidy</label>
                                        <div class="col-lg-9">
                                            <input type="text" :value="formatPrice(calculateTotalSubsidy)" class="form-control form-control-sm" disabled="" />
                                        </div>
                                    </div>
                                </form>
                               <!-- end of form for entering pricing details -->

                               <!-- Viewing of pricing details -->
                               <div v-if="!editable">
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">SRP</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.suggested_retail_price)}}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Wholesale Price</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.wholesale_price) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Fleet Price</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.fleet_price) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Dealer's Margin</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateMargin)}}  (@{{ curModel.dealers_margin }}%)</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">3 Yrs LTO Registration</span>
                                        <span class="col-md-8">@{{ formatPrice(curModel.lto_registration) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Freebies</span>
                                        <span class="col-md-8">@{{ formatPrice(sumFreebies) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Cost</span>
                                        <span class="col-md-8 kt-font-bold kt-font-danger">@{{ formatPrice(calculateCost) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Promo Title</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ curModel.promo_title }}</span>
                                    </div>
                                      <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Promo</span>
                                        <span class="col-md-8 kt-font-boldest kt-font-primary">@{{ formatPrice(curModel.promo) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Net Cost</span>
                                        <span class="col-md-8 kt-font-bold kt-font-primary">@{{ formatPrice(calculateNetCost) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Subsidy</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateSubsidy) }}</span>
                                    </div>
                                    <div class="row kt-margin-b-5">
                                        <span class="col-md-4 kt-font-bold">Total IPC Subsidy</span>
                                        <span class="col-md-8">@{{ formatPrice(calculateTotalSubsidy) }}</span>
                                    </div>
                                </div>
                               <!-- end of viewing of pricing details -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"  v-if="editable">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-success" @click="saveFPCItem()">Save</button>
              <!--   <a href="#" @click.prevent="printPrintConfirmation(project_id)" class="btn btn-primary">Print</a> -->
               <!--  <button type="button" v-if="active_tab == 1" class="btn btn-primary" @click="addRow()">Add row</button> -->
            </div>
        </div>
    </div>
</div>