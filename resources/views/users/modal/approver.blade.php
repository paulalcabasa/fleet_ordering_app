<div class="modal fade" id="approverModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-md-9">
                        <select class="form-control form-control-sm" v-model="selected_dealer_manager">
                            <option value="">Select dealer manager</option>
                            <option v-for="(row,index) in cur_dealer_managers" :value="index">
                                @{{ row.first_name + ' ' + row.last_name }}
                            </option>
                        </select> 
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary btn-sm" @click="addApprover">Add</button>
                    </div>
                </div> 
                
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Hierarchy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,index) in cur_approvers">
                            <td>
                                <a href="#" @click.prevent="deleteApprover(index)">
                                    <i class="flaticon flaticon-delete kt-margin-r-10 kt-font-danger"></i>
                                </a>
                            </td>
                            <td>@{{ row.name }}</td>
                            <td><input type="text" size="3" class="form-control form-control-sm" v-model="row.hierarchy"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>