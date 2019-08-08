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
                        <div class="card">
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
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Quantity</td>
                                    <td>Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in curDeliveryDetails">
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ row.delivery_date }}</td>
                                </tr>
                            
                            </tbody>
                        </table>                    
                    </div>
                </div>
    
            </div>
      
        </div>
    </div>
</div>