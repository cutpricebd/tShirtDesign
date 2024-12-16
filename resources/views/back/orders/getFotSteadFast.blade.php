@foreach ($orders as $order)
    <tr id="sf_courier_item_{{$order->id}}">
        <td>
            <input type="hidden" class="order_id" value="{{$order->id}}">
            <input type="hidden" class="queue_status" value="queue">
            {{$loop->index + 1}}
        </td>
        <td>
            {{$order->shipping_full_name}}
            <br>
            {{$order->shipping_street}}
        </td>
        <td>
            {{amount($order->grand_total)}}
        </td>
        <td class="courier_status">
            <i class="fas fa-spinner fa-spin" style="font-size: 20px"></i>
        </td>
    </tr>
@endforeach
