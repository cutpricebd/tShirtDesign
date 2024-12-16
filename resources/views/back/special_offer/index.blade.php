@extends('back.layouts.master')
@section('title', 'Special Offer')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Offers list</h5>

        <a href="{{route('back.special-offer.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Position</th>
                <th scope="col">Image</th>
                <th scope="col">Product</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($special_offers as $special_offer)
                    <tr>
                        <th scope="row">{{$special_offer->id}}</th>
                        <td>{{$special_offer->position}}</td>
                        <td><img src="{{$special_offer->img_paths['small']}}" style="width: 35px" alt=""></td>
                        <td>{{$special_offer->product->title ?? ''}}</td>
                        <td>
                            @include('switcher::switch', [
                                'table' => 'special_offers',
                                'data' => $special_offer
                            ])
                        </td>
                        <td class="text-right">
                            <div class="d-inline-block" style="width: 80px">
                                <a class="btn btn-success btn-sm" href="{{route('back.special-offer.edit', $special_offer->id)}}"><i class="fas fa-edit"></i></a>

                                <form class="d-inline-block" action="{{route('back.special-offer.destroy', $special_offer->id)}}" method="POST">
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
