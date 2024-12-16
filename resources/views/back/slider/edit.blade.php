@extends('back.layouts.master')
@section('title', 'Edit Slider')

@section('master')
<div class="card-header no_icon">
    <a href="{{route('back.sliders.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> Back</a>
    <a href="{{route('back.sliders.delete', $slider->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i> Delete</a>
</div>

<form action="{{route('back.sliders.update', $slider->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Image Title(For SEO)*</b></label>
                                <input type="text" class="form-control form-control-sm" name="text_1" value="{{old('text_1') ?? $slider->text_1}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Slider onclick URL</b></label>
                                <input type="text" class="form-control form-control-sm" name="button_1_url" value="{{old('button_1_url')?? $slider->button_1_url}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            @include('back.layouts.image-upload', [
                                'required' => false,
                                'image' => $slider->img_paths
                            ])
                            <p>Size: 1110*280px</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Update</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($sliders as $i => $slider)
                                <div class="carousel-item {{($i == 0) ? 'active' : ''}}">
                                    <img style="max-height:450px;object-fit: cover;" src="{{$slider->img_paths['original']}}" class="d-block w-100" >
                                </div>
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('back.sliders.position') }}" method="post">
                @csrf

                <div class="card border-light mt-3 shadow">
                    <div class="card-body">
                        <ul class="moveContent npnls">
                            @foreach($sliders as $slider)
                                <li class="{{$slider->id}}">
                                    <i class="fa fa-arrows-alt"></i>
                                    <img src="{{$slider->img_paths['medium']}}" >
                                    <input type="hidden" name="position[]" value="{{$slider->id}}">

                                    <div class="float-right">
                                        <a class="btn btn-success btn-sm" href="{{route('back.sliders.edit', $slider->id)}}" style="color:#fff"><i class="fa fa-edit"></i></a>

                                        <a href="{{route('back.sliders.delete', $slider->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success">Update position</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</form>
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 400,
                filebrowserUploadUrl: "{{route('imageUpload')}}?"
            });
        });
    </script>
@endsection

