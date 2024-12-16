<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coupon Report</title>
</head>

<body style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';" data-saferedirecturl="https://www.google.com/url?q=http://localhost&amp;source=gmail&amp;ust=1607844883689000&amp;usg=AFQjCNE16dMwx_olZ4z84pumj26bbtpg_g">
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 100%;overflow:hidden">
                    <img style="width: 100px; display:inline-block;float:left" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQp0vqAhuT3qyL72y_sdyJHNBxOHrWpENh_GA&usqp=CAU">
                    <h1 style="float: left;text-transform: uppercase;margin-top: 50px;margin-left: 15px;">{{$settings_g['title'] ?? env('APP_NAME')}}</h1>
                </th>
            </tr>
        </thead>
    </table>

    <table style="border-collapse: collapse;width: 100%;">
        <thead>
            <tr>
               <th style="border: 1px solid black;text-align:left">SL.</th>
               <th style="border: 1px solid black;text-align:left">Order ID</th>
               <th style="border: 1px solid black;text-align:left">Date</th>
               <th style="border: 1px solid black;text-align:left">Code</th>
               <th style="border: 1px solid black;text-align:left;text-align:right">Discount Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $key => $order)
                <tr>
                    <td style="border: 1px solid black"> {{$key + 1}} </td>
                    <td style="border: 1px solid black"> {{ $order->id }} </td>
                    <td style="border: 1px solid black"> {{ date('Y-m-d', strtotime($order->created_at)) }} </td>
                    <td style="border: 1px solid black"> {{ $order->coupon_code }} </td>
                    <td style="border: 1px solid black;text-align:right"> {{ ($settings_g['currency_symbol'] ?? '$') . number_format($order->discount_amount, 2) }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
