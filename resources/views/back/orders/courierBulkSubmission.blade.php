@extends('back.layouts.master')
@section('title', 'Courier Bulk Submission')

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@section('master')
<div class="card-header">
    <h5 class="d-inline-block">Selected Order List</h5>
</div>

<div class="card border-light mt-3 shadow">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">
                    Sl
                </th>
                <th scope="col">Shipping Name</th>
                <th scope="col">
                    Shipping Address
                    <p class="mb-0"><small>Address should be in English only!</small></p>
                </th>
                <th scope="col">
                    Mobile Number
                    <p class="mb-0"><small>Mobile Number should be in English only & please remove +88 from mobile number!</small></p>
                </th>
                <th scope="col">Courier Location</th>
                <th>Collection Amount</th>
                <th>Weight</th>
                <th>Shipping Note</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="selected_list_{{$order->id}}">
                            <td>
                                {{$loop->index + 1}}
                                <input type="hidden" name="order[]" value="{{$order->id}}">
                            </td>
                            <td>
                                <input type="text" step="any" class="form-control pathao_name" value="{{$order->shipping_full_name}}" required>
                            <td>
                                <textarea class="form-control" cols="30" rows="4">{{$order->shipping_full_address}}</textarea>
                            </td>
                            <td>
                                <input type="text" class="form-control pathao_phone_number" name="phone_number" value="{{$order->shipping_mobile_number}}">
                            </td>
                            <td>

                            </td>
                            <td>
                                <input type="number" step="any" class="form-control pathao_collect_amount" value="{{$order->grand_total}}" name="collect_amount" required>
                            </td>
                            <td>
                                <select name="weight" class="form-control pathao_weight" name="weight" required>
                                    <option value="0.5">0.5Kg</option>
                                    <option value="1">1Kg</option>
                                    <option value="2">2</option>
                                    <option value="3">3Kg</option>
                                    <option value="4">4Kg</option>
                                    <option value="5">5Kg</option>
                                    <option value="6">6Kg</option>
                                    <option value="7">7Kg</option>
                                    <option value="8">8Kg</option>
                                    <option value="9">9Kg</option>
                                    <option value="10">10Kg</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control pathao_shipping_note" value="{{$order->note}}" name="note">
                            </td>
                            <td class="status"></td>
                        </tr>
                    @endforeach
                </tbody>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <button class="btn btn-info">Submit</button>
    </div>
</div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script>
        $('.select_search').selectpicker({
            liveSearch: true
        });
    </script>
@endsection
