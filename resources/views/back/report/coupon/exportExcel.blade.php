<table>
	<thead>
		<tr>
			<th>SL.</th>
			<th>Order ID</th>
			<th>Date</th>
			<th>Code</th>
			<th>Discount Amount</th>
		</tr>
	</thead>
	<tbody>
        @foreach($orders as $key => $order)
            <tr>
                <td> {{$key + 1}} </td>
                <td> #{{ $order->id }} </td>
                <td> {{ date('Y-m-d', strtotime($order->created_at)) }}</td>
                <td> {{ $order->coupon_code }} </td>
                <td> {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->discount_amount, 2) }} </td>
            </tr>
        @endforeach
	</tbody>
</table>
