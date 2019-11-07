<table>
    <thead>
        <tr>
            <th>Project ID</th>
            <th width="100">Customer Name</th>
            <th width="30">Account Name</th>
            <th>Date Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inquiries as $inquiry)
        <tr>
            <td>{{ $inquiry->project_id }}</td>
            <td>{{ $inquiry->customer_name }}</td>
            <td>{{ $inquiry->account_name }}</td>
            <td>{{ $inquiry->date_created }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
