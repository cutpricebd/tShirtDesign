<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Order Name</th>
			<th>Tax Amount</th>
		</tr>
	</thead>
	<tbody>
        @foreach($orders as $key => $order)
            <tr>
                <td> {{$key + 1}} </td>
                <td> {{ date('Y-m-d', strtotime($order->created_at)) }}</td>
                <td> {{ $order->full_name }} </td>
                <td> {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->tax_amount, 2) }} </td>
            </tr>
        @endforeach
	</tbody>
</table>
