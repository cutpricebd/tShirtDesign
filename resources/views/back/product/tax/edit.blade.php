@extends('back.layouts.master')
@section('title', 'Edit TAX')

@section('master')
<div class="card">
    <div class="card-header no_icon">
        <a href="{{route('back.taxes.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>

        <form class="d-inline-block" action="{{route('back.taxes.destroy', $tax->id)}}" method="POST">
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

            <form action="{{route('back.taxes.update', $tax->id)}}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{old('name') ?? $tax->title}}" required>
                    </div>
                    <div class="form-group">
                        <label>TAX Rate*</label>
                        <input type="number" class="form-control form-control-sm" name="rate" value="{{old('rate') ?? $tax->amount}}" required>
                    </div>
                    <div class="form-group">
                        <label>TAX Type*</label>

                        <select name="type" name="type" class="form-control form-control-sm" required>
                            <option value="Percentage" {{$tax->type == 'Percentage' ? 'selected' : ''}}>Percentage</option>
                            <option value="Fixed" {{$tax->type == 'Fixed' ? 'selected' : ''}}>Fixed</option>
                        </select>
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
