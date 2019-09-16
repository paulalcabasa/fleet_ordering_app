<!--begin::Modal-->
<div class="modal fade" id="fpcApprovalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="kt-font-transform-c">@{{ action }}</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">    
                <div class="form-group" v-show="action == 'approve' || action == 'attach'">
                    <label>Attach signed copy of FPC</label>
                    <div></div>
                    <div class="custom-file">
                        <input type="file"  @change="validateFileSize('fpc')" class="custom-file-input" ref="customFile" name="fpc_attachment[]" id="fpc_attachment" multiple="true">
                        <label class="custom-file-label" for="attachment">@{{ fpc_attachment_label }}</label>
                         <ul style="list-style:none;padding-left:0;" class="kt-margin-t-10">
                            <li v-for="(row,index) in fpc_attachment">
                                <span>@{{ row.orig_filename }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group" v-show="action == 'approve' || action == 'cancel'">
                    <label>
                        <span v-if="action == 'approve'">Remarks</span>
                        <span v-if="action == 'cancel'">Are you sure to cancel the FPC? Please state your reason.</span>
                    </label>
                    <textarea class="form-control" v-model.lazy="remarks"></textarea> 
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" v-if="action == 'approve' || action == 'attach'" @click="confirmApproval()">Confirm</button>
                <button type="button" class="btn btn-success" v-if="action == 'cancel'" @click="confirmCancellation()">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->