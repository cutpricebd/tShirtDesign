@extends('back.layouts.master')
@section('title', 'Testimonial')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Testimonial list</h5>

        <a href="{{route('back.testimonials.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Client Name</th>
                <th scope="col">Client logo</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($testimonials as $testimonial)
                    <tr>
                        <th scope="row">{{$testimonial->id}}</th>
                        <td>{{$testimonial->client_name}}</td>
                        <td><img src="{{$testimonial->img_paths['small']}}" style="width: 35px" alt=""></td>
                        <td>{{$testimonial->status == 1 ? 'Active' : 'Disabled'}}</td>
                        <td class="text-right">
                            <div class="d-inline-block" style="width: 80px">
                                <a class="btn btn-success btn-sm" href="{{route('back.testimonials.edit', $testimonial->id)}}"><i class="fas fa-edit"></i></a>
                                <form class="d-inline-block" action="{{route('back.testimonials.destroy', $testimonial->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf

                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
                                </form>
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

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "asc"]],
        });
    });
</script>
@endsection
