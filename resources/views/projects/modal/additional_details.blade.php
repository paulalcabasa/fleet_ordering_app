<div class="modal fade" id="additionalDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delivery Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>