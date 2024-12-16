<div class="text-right">
    @if(!$data->deleted_at)
    <div class="d-inline-block" style="width: 80px;">
        @if($type == 'stock')
        <a class="btn btn-success btn-sm" href="{{route('back.adjustments.create', ['product_id' => $data->id])}}"><i class="fas fa-edit"></i></a>
        @else
        <a class="btn btn-success btn-sm" href="{{route('back.products.edit', $data->id)}}"><i class="fas fa-edit"></i></a>
        @endif

        <form class="d-inline-block" action="{{route('back.products.destroy', $data->id)}}" method="POST">
            @method('DELETE')
            @csrf

            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you like to delete this item permanently?')"><i class="fas fa-trash"></i></button>
        </form>
    </div>
    @else
    Deleted
    @endif
</div>
