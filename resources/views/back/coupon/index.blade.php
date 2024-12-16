@extends('back.layouts.master')
@section('title', 'Coupons')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Coupons list</h5>

        <a href="{{route('back.coupons.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                {{-- <th scope="col" style="width: 50px">#</th> --}}
                <th scope="col">Code</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Maximum Use</th>
                <th scope="col">Total Use</th>
                <th scope="col">Expire Date</th>
                <th scope="col">Status</th>
                <th scope="col">Visibility</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        {{-- <th scope="row">{{$coupon->id}}</th> --}}
                        <td>{{$coupon->code}}</td>
                        <td class="text-capitalized">{{$coupon->discount_type}}</td>
                        <td>{{$coupon->amount}}</td>
                        <td>{{$coupon->maximum_use ?? 'N/A'}}</td>
                        <td>{{count($coupon->Orders)}}</td>
                        <td>{{date('d/m/Y', strtotime($coupon->expiry_date))}}</td>
                        <td>
                            @include('switcher::switch', [
                                'table' => 'coupons',
                                'data' => $coupon,
                            ])
                        </td>
                        <td>
                            @include('switcher::switch', [
                                'table' => 'coupons',
                                'data' => $coupon,
                                'column' => 'visibility'
                            ])
                        </td>
                        <td class="text-right">
                            <div class="d-inline-block" style="width: 120px;">
                                <a href="{{route('back.coupons.edit', $coupon->id)}}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form class="d-inline-block" action="{{route('back.coupons.destroy', $coupon->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{route('back.coupons.show', $coupon->id)}}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

{{-- <script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "desc"]],
        });
    });
</script> --}}
@endsection
