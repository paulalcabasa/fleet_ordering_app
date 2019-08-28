<table class="table table-condensed"  style="font-size:90%;">
    <thead>
        <tr class="kt-font-bold bg-light-gray-1">
            <th>Actions</th>
            <th>Model</th>
            <th>Color</th>
            <th>Quantity</th>
            <th>PO Quantity</th>
            <th>Suggested Price</th>
        </tr>
    </thead>

    <tbody v-for="(vehicles,vehicle_type) in requirement">
        <tr v-for="(row,index) in vehicles">
            <td nowrap="nowrap">
                <a href="#"  title="Additional details" @click="showAdditionalDetails(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-info-circle"></i></a> 
                <a href="#"  title="Delivery schedule" @click="showDeliveryDetail(row)" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-calendar"></i></a>
            </td>
            <td>@{{ row.sales_model }}</td>
            <td><span :class="vehicle_colors[row.color]">&nbsp</span> @{{ row.color }}</td>
            <td>@{{ row.quantity }}</td>
            <td>@{{ row.po_qty }}</td>
            <td>@{{ formatPrice(row.suggested_price) }}</td>
        </tr>

        <tr class="kt-font-bold bg-light-gray-1">
           <th colspan="2">@{{ vehicle_type }}</th>
           <th>@{{ sumOrderQty(vehicle_type) }}</th> 
           <th>@{{ sumPOQty(vehicle_type) }}</th> 
           <th colspan="3">@{{ formatPrice(sumSuggestedPrice(vehicle_type)) }}</th> 
        </tr>
   
    </tbody>

    <tfoot>
        <tr class="bg-light-gray-2">
            <th colspan="2">Grand Total</th>
            <th>@{{ totalQty }}</th>
            <th>@{{ totalPOQty }}</th>
            <th colspan="3">@{{ formatPrice(totalSuggestedPrice) }}</th>
        </tr>
    </tfoot>
</table>