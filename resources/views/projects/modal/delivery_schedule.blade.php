<div class="modal fawarede" id="deliveryScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
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

                        <div class="card kt-margin-b-10">
                            <div class="card-header">Vehicle Details</div>
                            <div class="card-body">
                                <div class="details-item">
                                    <span class="details-label">Model</span>
                                    <span class="details-subtext">@{{ curModel }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Color</span>
                                    <span class="details-subtext">@{{ curColor }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Quantity</span>
                                    <span class="details-subtext">@{{ curQuantity}}</span>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">Other Details</div>
                            <div class="card-body">
                                <div class="details-item">
                                    <span class="details-label">Name of Body Builder</span>
                                    <span class="details-subtext">@{{ curBodyBuilder == null ? '-' : curBodyBuilder }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Rear Body Type</span>
                                    <span class="details-subtext">@{{ curRearBody == null ? '-' : curRearBody  }}</span>
                                </div>
                                <div class="details-item">
                                    <span class="details-label">Additional Items</span>
                                    <span class="details-subtext">@{{ curAdditionalItems == null ? '-' : curAdditionalItems  }}</span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- <table class="table">
                            <thead>
                                <tr>
                           
                                    <td>Date</td>
                                    <td>Quantity</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in curDeliveryDetails">
                                    <td>@{{ row.delivery_date_disp }}</td>
                                    <td>@{{ row.quantity }}</td>
                                </tr>
                            </tbody>
                        </table>   -->   
                        <div class="card kt-margin-b-10">
                            <div class="card-header">Requested Delivery Schedule</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <!--     <th></th> -->
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row,index) in curDeliveryDetails" v-if="row.owner_id == 6">
                                            <td>@{{ row.delivery_date_disp }}</td>
                                            <td>@{{ row.quantity }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                         
                                            <td>Total</td>
                                            <td>@{{ totalDeliveryQty(6) }}</td>
                                        </tr>
                                    </tfoot>
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
                                        <tr v-for="(row,index) in curDeliveryDetails" v-if="row.owner_id == 5">
                                            <td>@{{ row.delivery_date_disp }}</td>
                                            <td>@{{ row.quantity }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="kt-font-bold">
                                          
                                            <td>Total</td>
                                            <td>@{{ totalDeliveryQty(5) }}</td>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                        </div> 
                                  
                    </div>
                </div>
    
            </div>
      
        </div>
    </div>
</div>