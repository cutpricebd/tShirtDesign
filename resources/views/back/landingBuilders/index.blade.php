@extends('back.layouts.master')
@section('title', 'Landing Page Builders')

@section('master')
    <div class="card shadow mb-3">
        <div class="card-header">
            <h5 class="m-0 d-inline-block mt-1"><b>Landing Page Builders</b></h5>

            <a href="{{route('back.landingBuilders.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover table-sm" id="dataTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Design</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="text-dark">
                @foreach($landings as $landing)
                    <tr>
                        <td>{{ $loop->remaining + 1 }}</td>
                        <td>{{ $landing->title }}</td>
                        <td>{{ $landing->theme }}</td>
                        <td>
                            <a class="btn btn-info btn-sm mb-1" href="{{route('back.landingBuilders.edit', $landing->id)}}">Edit</a>
                            <a class="btn btn-primary btn-sm mb-1" href="{{route('back.landingBuilders.build', $landing->id)}}">Builder</a>
                            <a class="btn btn-success btn-sm mb-1" target="_blank" href="{{route('landing.landing', $landing->id)}}">View</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $('#dataTable').DataTable({
            "order": [[0, "desc"]]
        });
    </script>
@endsection
