@extends('back.layouts.master')
@section('title', 'Blog Categories')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Category list</h5>

        <a href="{{route('back.blogs.categories.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Sub Categories</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td>{{$category->title}}</td>
                        <td>
                            <ul>
                                @foreach ($category->Categories as $sub_category)
                                    <li>
                                        <a href="{{route('back.categories.edit', $sub_category->id)}}">{{$sub_category->title}}</a>

                                        <ul>
                                            @foreach ($sub_category->Categories as $sub_category)
                                                <li><a href="{{route('back.categories.edit', $sub_category->id)}}">{{$sub_category->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @include('switcher::switch', [
                                'table' => 'categories',
                                'data' => $category
                            ])
                        </td>
                        <td class="text-right">
                            <div class="d-inline-block" style="width: 80px">
                                <a class="btn btn-success btn-sm" href="{{route('back.categories.edit', $category->id)}}"><i class="fas fa-edit"></i></a>
                                <form class="d-inline-block" action="{{route('back.categories.destroy', $category->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf


                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
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
            order: [[0, "desc"]],
        });
    });
</script>
@endsection
