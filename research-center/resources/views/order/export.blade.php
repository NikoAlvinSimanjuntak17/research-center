<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            @php
                $totalArray = json_decode($order->totalprice, true);
                $totalAmount = is_array($totalArray) ? array_sum($totalArray) : 0;
            @endphp
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->nama ?? $order->user->name }}</td>
                <td>{{ $order->user->email }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                <td>{{ $totalAmount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
