@foreach($query as $data)
<tr>
    <td class="selectedID" data-product="{{$data->id}}">{{$data->id}}<input type="hidden" name="product[]" value="{{$data->id}}"></td>
    <td><img class="small" src="{{$data->getImage()}}"></td>
    <td>{{$data->name}}</td>
    <td>{{$data->AllMeta[0]->selling_price ?? 0}}</td>
    <td><span class="text-capitalize">{{$data->type}}</span></td>
    {{-- <td>
        <select class="selectpicker form-control google_categort" data-live-search="true">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{$category->category_id}}">{{$category->name}}</option>
            @endforeach
        </select>

        <script>
            $(".selectpicker").selectpicker();
        </script>
    </td> --}}
    <td><button class="btn btn-danger btn-sm removeSelected">Remove</button></td></td>
</tr>
@endforeach
