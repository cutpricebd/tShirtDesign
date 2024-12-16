@extends('back.layouts.master')
@section('title', 'Edit Shupping Charge')

@section('master')
<div class="card">
    <div class="card-header no_icon">
        <a href="{{route('back.shippings.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>

        <form class="d-inline-block" action="{{route('back.shippings.destroy', $charge->id)}}" method="POST">
            @method('DELETE')
            @csrf

            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i> Delete</button>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Edit Information</h5>
            </div>

            <form action="{{route('back.shippings.update', $charge->id)}}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    {{-- <div class="form-group">
                        <label>Province*</label>
                        <select name="state" class="form-control form-control-sm" required>
                            <option value="">Select Province</option>
                            <option value="Any" {{'Any' == $charge->state ? 'selected' : ''}}>Any</option>
                            @foreach (Info::provinces() as $province)
                                <option value="{{$province}}" {{$province == $charge->state ? 'selected' : ''}}>{{$province}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control form-control-sm" name="country" value="{{old('country') ?? $charge->country}}" disabled>
                    </div>
                    <div class="form-group">
                        <label>State/Province</label>
                        <input type="text" class="form-control form-control-sm" name="country" value="{{old('country') ?? $charge->country}}" disabled>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control form-control-sm" name="city" value="{{old('city') ?? $charge->city}}">
                    </div>
                    <div class="form-group">
                        <label>Shipping Amount*</label>
                        <input type="number" step="any" class="form-control form-control-sm" name="amount" value="{{old('amount') ?? $charge->amount}}">
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Update</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
