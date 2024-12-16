@extends('back.layouts.master')
@section('title', 'Purchase')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>

<style>
    .adjustment_tr:hover{cursor: pointer}
</style>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">List</h5>

        {{-- <a href="{{route('back.adjustments.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> New Adjustment</a> --}}
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm table-hover" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Added By</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Note</th>
                {{-- <th scope="col" class="text-right">Action</th> --}}
              </tr>
            </thead>
            <tbody>
                @foreach ($adjustments as $adjustment)
                    <tr class="{{$adjustment->deleted_at ? 'table-danger' : ''}} adjustment_tr">
                        <th scope="row" onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');">{{$adjustment->id}}</th>
                        <td onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');">{{date('d/m/Y', strtotime($adjustment->created_at))}}</td>
                        <td onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');">{{$adjustment->added_by}}</td>
                        <td onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');">{{$settings_g['currency_symbol'] . number_format($adjustment->total_amount, 2)}}</td>
                        <td onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');">{{$adjustment->delete_note ?? $adjustment->note}}</td>
                        {{-- <td onclick="return detailItem(`adjustment`, '{{$adjustment->id}}');" class="text-right">
                            @if(!$adjustment->deleted_at)
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="{{$adjustment->id}}" type="button" data-toggle="modal" data-target=".deleteModal"><i class="fas fa-trash"></i></button>
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade deleteModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailsModalLabel">Delete Note*</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.adjustments.delete')}}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="adjustment_id" class="adjustment_id">

            <div class="modal-body">
                <div class="form-group">
                    {{-- <label><b>Delete Note</b>*</label> --}}
                    <input type="text" class="form-control" name="delete_note" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you want to delete permanently from product list?')"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </form>
      </div>
    </div>
</div>
<!-- End Delete Modal -->
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "desc"]],
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        let item_id = $(this).data('id');

        $('.adjustment_id').val(item_id);
    });

    // $(document).on('click', '.adjustment_tr', function(){
    //     alert(12345);
    // });
</script>
@endsection
