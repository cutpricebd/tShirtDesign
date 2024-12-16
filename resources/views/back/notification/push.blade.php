@extends('back.layouts.master')
@section('title', 'Push Notification')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="row">
    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">History</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Text</th>
                        <th scope="col" class="text-right">URL</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pushes as $push)
                            <tr>
                                <th scope="row">{{$push->id}}</th>
                                <td>{{date('d/m/Y', strtotime($push->created_at))}}</td>
                                <td>{{$push->text}}</td>
                                <td class="text-right">
                                    @if($push->url)
                                    <a class="btn btn-sm btn-success" target="_blank" href="{{$push->url}}"><i class="fas fa-eye"></i></a>
                                    @else
                                    N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <form action="{{route('back.notification.push')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h5 class="d-inline-block">Sens new</h5>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label><b>Text*</b></label>
                        <input type="text" class="form-control form-control-sm" name="text" value="{{old('text')}}" required>
                    </div>
                    <div class="form-group">
                        <label><b>URL</b></label>
                        <input type="url" class="form-control form-control-sm" name="url" value="{{old('url')}}">
                    </div>
                    <div class="form-group">
                        <label><b>Image</b></label>
                        <input type="file" class="form-control form-control-sm" name="image" accept="image/*" value="{{old('image')}}">
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Submit</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "desc"]],
        });
    });
</script>
@endsection
