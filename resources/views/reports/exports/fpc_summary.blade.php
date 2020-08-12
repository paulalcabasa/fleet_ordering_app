<table>
    <thead style="font-weight:bold;">
        <tr>
            <th width="30">Date Created</th>
            <th width="20">Project No</th>
            <th width="20">FPC No</th>
            <th width="20">Dealer</th>
            <th width="100">Customer</th>
            <th width="30">Sales Model</th>
            <th>Quantity</th>
            <th width="20">Body Application</th>
            <th width="20">WSP</th>
            <th width="20">SRP</th>
            <th width="20">Discount</th>
            <th width="20">Fleet Price</th>
            <th width="20">Dealer Margin</th>
            <th width="30">Inclusion</th>
            <th width="20">FPC Validity</th>
            <th width="30">Competitor Brand</th>
            <th width="30">Competitor Model</th>
            <th width="30">Competitors Price</th>
            <th width="30">Prepared by</th>
            <th width="30">FPC Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fpc as $row)
        <tr>
            <td>{{ $row->date_created }}</td>
            <td>{{ $row->project_no }}</td>
            <td>{{ $row->fpc_ref_no }}</td>
            <td>{{ $row->account_name }}</td>
            <td>{{ $row->customer_name }}</td>
            <td>{{ $row->sales_model }}</td>
            <td>{{ $row->quantity }}</td>
            <td>{{ $row->body_application }}</td>
            <td align="right">{{ number_format($row->wholesale_price,2) }}</td>
            <td align="right">{{ number_format($row->suggested_retail_price,2) }}</td>
            <td align="right">{{ number_format($row->discount,2) }}</td>
            <td align="right">{{ number_format($row->fleet_price,2) }}</td>
            <td align="right">{{ number_format($row->dealers_margin,2) }}</td>
            <td>{{ $row->inclusion }}</td>
            <td>{{ $row->validity }}</td>
            <td>{{ $row->competitor_brand }}</td>
            <td>{{ $row->competitor_model }}</td>
            <td>{{ $row->competitors_price }}</td>
            <td>{{ $row->prepared_by }}</td>
            <td>{{ $row->fpc_status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
