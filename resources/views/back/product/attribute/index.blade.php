@extends('back.layouts.master')
@section('title', 'Attributes')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>

<style>
    table li{padding: 8px 0;
    border-bottom: 1px solid #ddd;}
</style>
@endsection

@section('master')
<div class="row">
    <div class="col-md-4">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Create attribute</h5>
            </div>

            <form action="{{route('back.attributes.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Name*</b></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Create</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </form>
        </div>

        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Create attribute item</h5>
            </div>

            <form action="{{route('back.attributes.itemStore')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label><b>Select Attribute*</b></label>
                        <select name="attribute" class="form-control form-control-sm" required>
                            <option value="">Select Attribute</option>

                            @foreach ($attributes as $attribute)
                                <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Item Name*</b></label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{old('name')}}" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Create</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </form>
        </div>

        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h6 class="d-inline-block">How to add Product Size</h6>
            </div>
            <div class="card-body">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/51Znhi42HH8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5 class="d-inline-block">Attribute list</h5>
            </div>
            <div class="card-body table-bordered">
                <table class="table table-bordered table-sm" id="dataTable">
                    <thead>
                      <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Name</th>
                        <th scope="col">Items</th>
                        <th scope="col" class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                {{-- <th scope="row">{{$attribute->id}}</th> --}}
                                <td>{{$attribute->name}}</td>
                                <td>
                                    <ul>
                                        @foreach ($attribute->AttributeItems as $attribute_item)
                                            <li>
                                                <div>
                                                    <span>{{$attribute_item->name}}</span>

                                                    <div class="float-right" style="width: 80px">
                                                        <a href="#" class="edit_item_btn btn btn-success btn-sm" data-name="{{$attribute_item->name}}" data-id="{{$attribute_item->id}}" data-toggle="modal" data-target="#editItemModal"><i class="fas fa-edit"></i></a>

                                                        <a class="btn btn-danger btn-sm" href="{{route('back.attributes.itemDestroy', $attribute_item->id)}}" onclick="return confirm('Are you sure to remove?');"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-right">
                                    <a href="#" class="edit_btn btn btn-success btn-sm" data-name="{{$attribute->name}}" data-id="{{$attribute->id}}" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                                    <form class="d-inline-block" action="{{route('back.attributes.destroy', $attribute->id)}}" method="POST">
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
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit attribute</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('back.attributes.updateModal')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="" class="edit_id">

            <div class="modal-body">
                <div class="form-group">
                    <label><b>Name*</b></label>
                    <input type="text" class="form-control form-control-sm edit_name" name="name" value="{{old('name')}}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit attribute item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('back.attributes.itemUpdate')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="" class="edit_item_id">

            <div class="modal-body">
                <div class="form-group">
                    <label><b>Name*</b></label>
                    <input type="text" class="form-control form-control-sm edit_item_name" name="name" value="{{old('name')}}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
      </div>
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

    $(document).on('click', '.edit_btn', function(){
        let name = $(this).data('name');
        let id = $(this).data('id');

        $('.edit_id').val(id);
        $('.edit_name').val(name);
    });

    $(document).on('click', '.edit_item_btn', function(){
        let name = $(this).data('name');
        let id = $(this).data('id');

        $('.edit_item_id').val(id);
        $('.edit_item_name').val(name);
    });
</script>
@endsection
