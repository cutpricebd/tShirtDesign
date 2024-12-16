@extends('back.layouts.master')
@section('title', 'Edit Coupon')

@section('head')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
<div class="card">
    <div class="card-header no_icon">
        <a href="{{route('back.coupons.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
        <a href="{{route('back.coupons.create')}}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Create</a>
        <a href="{{route('back.coupons.show', $coupon->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i> View Details</a>

        <form class="d-inline-block" action="{{route('back.coupons.destroy', $coupon->id)}}" method="POST">
            @method('DELETE')
            @csrf

            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i> Delete</button>
        </form>
    </div>
</div>

<form action="{{route('back.coupons.update', $coupon->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="form-group">
                        <label><b>Cupon Code*</b></label>
                        <input type="text" class="form-control form-control-sm" name="code" value="{{old('code') ?? $coupon->code}}" required>
                    </div>

                    <div class="form-group">
                        <label><b>Description</b></label>

                        <textarea class="form-control form-control-sm" name="description" cols="30" rows="3">{{old('description') ?? $coupon->description}}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block"><b>Select Customer</b></label>
                                <select name="customer" class="form-control form-control-sm selectpicker">
                                    <option value="" selected>fdgfgdg</option>
                                </select>
                                @if($coupon->User)
                                <label><b>Only useable for:</b> {{$coupon->User->full_name ?? ''}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Maximum Use</b></label>

                                <input type="number" class="form-control form-control-sm" name="maximum_use" value="{{old('maximum_use') ?? $coupon->maximum_use}}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="d-block"><b>Visibility*</b></label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibility_visible" value="1" {{$coupon->visibility == 1 ? 'checked' : ''}} required>
                                    <label class="form-check-label" for="visibility_visible">Visible</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibility_hidden" value="0" {{$coupon->visibility == 0 ? 'checked' : ''}} required>
                                    <label class="form-check-label" for="visibility_hidden">Hidden</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label><b>Discount type*</b></label>
                                <select name="discount_type" class="form-control form-control-sm" required>
                                    <option value="percent" {{$coupon->discount_type == 'percent' ? 'selected' : ''}}>Percentage discount</option>
                                    <option value="fixed" {{$coupon->discount_type == 'fixed' ? 'selected' : ''}}>Fixed discount</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><b>Coupon Amount*</b></label>
                                <input type="number" class="form-control form-control-sm" name="amount" value="{{old('amount') ?? $coupon->amount}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Expiry date</b></label>
                                <input type="date" class="form-control form-control-sm" name="expiry_date" value="{{old('expiry_date') ?? date('Y-m-d', strtotime($coupon->expiry_date))}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><b>Minimum spend</b></label>
                                <input type="number" class="form-control form-control-sm" name="minimum_spend" value="{{old('minimum_spend') ?? $coupon->minimum_spend}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label><b>Maximum spend</b></label>
                                <input type="number" class="form-control form-control-sm" name="maximum_spend" value="{{old('maximum_spend') ?? $coupon->maximum_spend}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success btn-block">Update</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer')
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        // Select2
        $('.selectpicker').select2({
            placeholder: "Search Customer",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("back.customers.selectList") }}?type=customer',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
