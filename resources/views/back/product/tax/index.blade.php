@extends('back.layouts.master')
@section('title', 'TAXes')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="row">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">TAX List</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Type</th>
                        <th scope="col" class="text-right">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($taxes as $taxe)
                            <tr>
                                <td>{{$taxe->id}}</td>
                                <td>{{$taxe->title}}</td>
                                <td>{{$taxe->amount}}</td>
                                <td>{{$taxe->type}}</td>
                                <td class="text-right">
                                    <a class="btn btn-success btn-sm" href="{{route('back.taxes.edit', $taxe->id)}}"><i class="fas fa-edit"></i></a>
                                    <form class="d-inline-block" action="{{route('back.taxes.destroy', $taxe->id)}}" method="POST">
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

            <form action="{{route('back.taxes.store')}}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label>Name*</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{old('name')}}" required>
                    </div>
                    <div class="form-group">
                        <label>TAX Rate*</label>
                        <input type="number" class="form-control form-control-sm" name="rate" value="{{old('rate')}}" required>
                    </div>
                    <div class="form-group">
                        <label>TAX Type*</label>

                        <select name="type" name="type" class="form-control form-control-sm" required>
                            <option value="Percentage">Percentage</option>
                            <option value="Fixed">Fixed</option>
                        </select>
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
    $('#dataTable').DataTable();
</script>
@endsection
