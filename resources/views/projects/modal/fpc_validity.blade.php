<!--begin::Modal-->
<div class="modal fade" id="validityModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request for Extension</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">   

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Ref No.</label>
                        <input type="text" class="form-control" disabled="disabled" :value="validityRequest.fpc_project_id"/>
                    </div>    
                    <div class="col-md-6">
                        <label>Validity</label>
                        <input type="text" class="form-control"  disabled="disabled" :value="validityRequest.validity_date | formatShortDate"/>
                    </div> 
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Request Date</label>
                        <input type="date" class="form-control" v-model="validityRequest.request_date" v-if="(user_type == 27 || user_type == 31) && validityRequest.action == 'create'" />
                        <input type="text" class="form-control" :value="validityRequest.request_date | formatShortDate" disabled="disabled" v-show="validityRequest.action == 'view' || validityRequest.action == 'approve'" />
                    </div>
                    <div class="col-md-6">
                        <label>Approved Date</label>
                        <input type="date" class="form-control" v-model="validityRequest.approved_date"  v-if="user_type == 32 || user_type == 33"  />
                        <input type="date" class="form-control" :value="validityRequest.approved_date" disabled="disabled"  v-if="user_type == 27 || user_type == 31" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Reason</label>
                        <textarea class="form-control" v-model="validityRequest.requestor_remarks" v-if="(user_type == 27 || user_type == 31) && validityRequest.action == 'create'"></textarea>
                        <textarea class="form-control" :value="validityRequest.requestor_remarks" disabled="disabled"  v-if="validityRequest.action == 'view' || validityRequest.action == 'approve'"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Approver Remarks</label>
                        <textarea class="form-control" :value="validityRequest.approver_remarks" disabled="disabled" v-if="user_type == 27 || user_type == 31"></textarea>
                        <textarea class="form-control" v-model="validityRequest.approver_remarks" v-if="user_type == 32 || user_type == 33"></textarea>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-success" @click="confirmRequest">Confirm</button>
                <button type="button"  class="btn btn-danger" @click="rejectRequest" v-if="user_type == 32 || user_type == 33">Reject</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->