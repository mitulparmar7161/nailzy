<table >
    <thead>
        <tr>
            <th>Date-Time</th>
            <th>Request Method</th>
            <th>Request URL</th>
            <th>Request Body</th>
            <th>Response Status</th>
            <th>Response Body</th>
        </tr>
    </thead>
    <tbody>
        @php
            // dd($data);
        @endphp
        @foreach ( $data as $row )
        <tr>
            @php
                //  dd($row);
            @endphp
            <td>{{ $row['date_time'] }}</td>
            <td>{{ $row['request']['method'] }}</td>
            <th>{{ $row['request']['url'] }}</th>
            <th>{{ $row['request']['body'] }}</th>
            <td>{{ $row['response']['status'] }}</td>
            <td>{{ $row['response']['body'] }}</td>
        </tr>
        @endforeach
        {{ $data->links() }}
    
    </tbody>
</table>