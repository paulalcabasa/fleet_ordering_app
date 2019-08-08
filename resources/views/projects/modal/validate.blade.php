<!--begin::Modal-->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Cancellation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">          
                <div class="form-group">
                    <label>Are you sure? Please enter reason for cancellation.</label>
                    <textarea class="form-control" v-model="remarks"></textarea>
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