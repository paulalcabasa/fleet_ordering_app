<div class="row">
    <div class="col-md-12">
        <form>  
            <div class="form-group">
                <label for="">Search criteria</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-primary" type="button" @click="searchOracleCustomer">Search</button>
                    </div>
                    <input type="text" class="form-control" v-model="search_criteria" placeholder="Search for...">
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Customer name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in matched_customers">
                    <td><button class="btn btn-success btn-sm" @click="updateOracleCustomer(row)">Match <i class="fa fa-check-circle"></i></button></td>
                    <td>@{{ row.party_name }}</td>
                </tr>
               
            </tbody>
        </table>
      
    </div>
</div>  