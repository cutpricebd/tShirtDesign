<table>
	<thead>
		<tr>
			<th>id</th>
			<th>title</th>
			<th>description</th>
			<th>availability</th>
			<th>condition</th>
			<th>price</th>
			<th>link</th>
			<th>image_link</th>
			<th>brand</th>
		</tr>
	</thead>
	<tbody>
        @php
            $title = $settings_g['title'] ?? env('APP_NAME');
        @endphp
        @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->description}}</td>
                <td>in stock</td>
                <td>new</td>
                <td>{{$product->sale_price}} BDT</td>
                <td>{{$product->route}}</td>
                <td>{{$product->img_paths['original']}}</td>
                <td>{{$product->Brand->title ?? $title}}</td>
            </tr>
        @endforeach
	</tbody>
</table>
