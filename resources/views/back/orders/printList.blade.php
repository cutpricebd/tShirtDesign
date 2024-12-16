<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Order List</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('back/css/style.css')}}">
    <link href="{{asset('back/css/print.css')}}" media="print" rel="stylesheet">
</head>
<body>
    <div class="text-center noPrint my-4">
        <button class="btn btn-info print_now">Print</button>
    </div>

    @foreach ($orders as $order)
    @include('back.orders.print2', [
        'for' => 'multiple'
    ])

    @if ($loop->iteration % 3 === 0)
    <div style="page-break-after: always"></div>
    @else
    <p style="border-bottom: 2px dotted #000"></p>
    @endif
    @endforeach
    {{-- <div class="row">
        @foreach ($orders as $order)
        <div class="col-md-3">
            <div class="text-center">
                <p class="mb-0 mt-4"><b>{{$order->full_name}}</b></p>
                <p>{{$order->shipping_mobile_number}}</p>

                ------------------
            </div>
        </div>
        @endforeach
    </div> --}}

    <div class="text-center noPrint my-4">
        <button class="btn btn-info print_now">Print</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            window.print();
        });
        $(document).on('click', '.print_now', function () {
            window.print();
        });
    </script>
</body>
</html>
