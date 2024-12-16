@extends('back.layouts.master')
@section('title', 'Shipping Charges')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="row">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Shipping Charges List</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                      <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Province/State</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col" class="text-center">Amount</th>
                        <th scope="col" class="text-right">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($charges as $charge)
                            <tr>
                                {{-- <td>{{$charge->id}}</td> --}}
                                <td>{{$charge->state}}</td>
                                <td>{{$charge->city ?? 'Any City'}}</td>
                                <td>{{$charge->country ?? 'Canada'}}</td>
                                <td class="text-center">{{($settings_g['currency_symbol'] ?? '$') . $charge->amount}}</td>
                                <td class="text-right">
                                    <a class="btn btn-success btn-sm" href="{{route('back.shippings.edit', $charge->id)}}"><i class="fas fa-edit"></i></a>
                                    <form class="d-inline-block" action="{{route('back.shippings.destroy', $charge->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf

                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Create New</h5>
            </div>

            <form action="{{route('back.shippings.store')}}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label>Country*</label>
                        <select name="country" class="form-control form-control-sm country_select" required>
                            {{--<option value="Canada">Canada</option>--}}
                            <option value="USA">USA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="state_text">State/Province*</label>
                        <select name="state" class="form-control form-control-sm states" required>
                            {{--@include('back.shipping.canada-states', ['any' => true])--}}
                            @include('back.shipping.usa-states', ['any' => true])
                            {{-- <option value="">Select Province</option>
                            <option value="Any">Any</option>
                            @foreach (Info::provinces() as $province)
                                <option value="{{$province}}">{{$province}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" name="city" value="{{old('city')}}">
                    </div>
                    <div class="form-group">
                        <label>Shipping Amount*</label>
                        <input type="number" step="any" class="form-control form-control-sm" name="amount" value="{{old('amount')}}">
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Create</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $('#dataTable').DataTable({
        order: [[0, "asc"]],
    });
</script>

@include('back.layouts.country-script', ['any' => true])
@endsection
