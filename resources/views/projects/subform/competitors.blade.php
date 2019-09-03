<div class="row" v-if="projectDetails.competitor_flag == 'Y'">
    <div class="col-md-8" v-if="competitors.length > 0">
        <div class="card">
            <div class="card-header">Vehicles</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Price</th> 
                                <th>Isuzu Model</th> 
                                <th>Suggested Price</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row,index) in competitors">
                                <td>@{{ row.brand }}</td>
                                <td>@{{ row.model }}</td>
                                <td>@{{ formatPrice(row.price) }}</td>
                                <td>
                                    @{{ row.sales_model }} 
                                    <span class="kt-badge kt-badge--brand kt-badge--inline">@{{ row.color}}</span>
                                </td>
                                <td>@{{ formatPrice(row.suggested_price) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4" v-if="competitor_attachments.length > 0">
        <div class="card">
            <div class="card-header">Attachment</div>
            <div class="card-body">
                <ul style="list-style:none;padding:0;">
                    <li v-for="(row,index) in competitor_attachments">
                        <a :href="base_url + '/' + row.symlink_dir + row.filename " download>@{{ row.orig_filename }}</a>
                    </li>
                </ul>
            </div>
        </div>  
    </div>
</div>  
<p v-if="projectDetails.competitor_flag == 'N'">@{{ projectDetails.competitor_remarks }}</p>