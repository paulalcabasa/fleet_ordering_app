<div class="modal fade" data-backdrop="static" data-keyboard="false" id="fpc_details_modal" style="z-index:1131" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Price Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card kt-margin-b-10">
                            <div class="card-header">Requested Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched" v-if="row.owner_id == 6"> 
                                            <td>@{{ row.delivery_date }}</td> 
                                            <td>@{{ row.quantity }}</td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Recommended Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliverySched" v-if="row.owner_id == 5"> 
                                            <td>@{{ row.delivery_date }}</td> 
                                            <td>@{{ row.quantity }}</td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" v-show="curFreebies.length > 0">
                            <div class="card-header">Other Items</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Cost to</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curFreebies">
                                            <td>@{{ row.description}}</td> 
                                            <td>@{{ row.owner_name }}</td> 
                                            <td>@{{ row.amount | formatPeso }}</td> 
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th align="right">P @{{ sumFreebies | formatPeso }}</th>
                                        </tr> 
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>