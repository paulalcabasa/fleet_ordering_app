<table>
    <thead style="font-weight:bold;">
        <tr>
            <th width="20">Project No</th>
            <th width="20">FPC No</th>
            <th width="20">Dealer</th>
            <th width="100">Customer</th>
            <th width="30">Date Created</th>
            <th width="30">Sales Model</th>
            <th width="20">Color</th>
            <th>Quantity</th>
            <th width="20">WSP</th>
            <th width="20">SRP</th>
            <th width="20">Discount</th>
            <th width="20">Promo</th>
            <th width="20">Fleet Price</th>
            <th width="30">Prepared by</th>
            <th width="30">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fpc as $row)
        <tr>
            <td>{{ $row->project_no }}</td>
            <td>{{ $row->fpc_ref_no }}</td>
            <td>{{ $row->account_name }}</td>
            <td>{{ $row->customer_name }}</td>
            <td>{{ $row->date_created }}</td>
            <td>{{ $row->sales_model }}</td>
            <td>{{ $row->color }}</td>
            <td>{{ $row->quantity }}</td>
            <td>{{ $row->wholesale_price }}</td>
            <td>{{ $row->suggested_retail_price }}</td>
            <td>{{ $row->discount }}</td>
            <td>{{ $row->promo }}</td>
            <td>{{ $row->fleet_price }}</td>
            <td>{{ $row->prepared_by }}</td>
            <td>{{ $row->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
