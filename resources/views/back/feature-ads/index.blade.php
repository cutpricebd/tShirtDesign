@extends('back.layouts.master')
@section('title', 'Feature Ads')

@section('head')
    <style>
        .banner_btns{position: absolute;
        top: 40px;
        right: 40px;}
    </style>
@endsection

@section('master')
<div class="row">
    <div class="col-md-8">
        <form action="{{route('back.feature-ads.store')}}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h5>Create</h5>
                </div>

                <div class="card-body">
                    <input type="hidden" name="placement" value="Place 1">
                    <div class="row">
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Placement *</b></label>
                                <select name="placement" class="form-control form-control-sm" required>
                                    <option value="Place 1">Place 1</option>
                                    <option value="Place 2">Place 2</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Title</b></label>
                                <input type="text" class="form-control form-control-sm" name="title" value="{{old('title')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Custom Text*</b></label>

                                <textarea id="editor" class="form-control form-control-sm" name="description" cols="30" rows="3" required>{{old('description')}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <img class="img-thumbnail uploaded_img" style="width: 50%;max-width: 220px" src="{{asset('img/default-img.png')}}">

                            <div class="form-group">
                                <label><b>Feature Image*</b></label>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input image_upload" name="image" accept="image/*" required>
                                    <label class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Create</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-4">
        <form action="{{route('back.feature-ads.position')}}" method="post">
            @csrf

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h5>Feature Ads</h5>
                </div>

                <div class="card-body">
                    <ul class="moveContent npnls">
                        @foreach($ads_1 as $ad)
                            <li class="{{$ad->id}}">
                                <i class="fa fa-arrows-alt"></i>
                                <img src="{{$ad->img_paths['medium']}}" >
                                <input type="hidden" name="position[]" value="{{$ad->id}}">

                                <div class="float-right">
                                    <a class="btn btn-success btn-sm" href="{{route('back.feature-ads.edit', $ad->id)}}" style="color:#fff"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('back.feature-ads.delete', $ad->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></a>
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

    {{-- <div class="col-md-4">
        <form action="{{route('back.feature-ads.position')}}" method="post">
            @csrf

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h5>Place 2</h5>
                </div>

                <div class="card-body">
                    <ul class="moveContent npnls">
                        @foreach($ads_2 as $ad)
                            <li class="{{$ad->id}}">
                                <i class="fa fa-arrows-alt"></i>
                                <img src="{{$ad->img_paths['medium']}}" >
                                <input type="hidden" name="position[]" value="{{$ad->id}}">

                                <div class="float-right">
                                    <a class="btn btn-success btn-sm" href="{{route('back.feature-ads.edit', $ad->id)}}" style="color:#fff"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('back.feature-ads.delete', $ad->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></a>
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
    </div> --}}

    {{-- <div class="col-md-4">
        <form action="{{route('back.feature-ads.position')}}" method="post">
            @csrf

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h5>Place 3</h5>
                </div>

                <div class="card-body">
                    <ul class="moveContent npnls">
                        @foreach($ads_3 as $ad)
                            <li class="{{$ad->id}}">
                                <i class="fa fa-arrows-alt"></i>
                                <img src="{{$ad->img_paths['medium']}}" >
                                <input type="hidden" name="position[]" value="{{$ad->id}}">

                                <div class="float-right">
                                    <a class="btn btn-success btn-sm" href="{{route('back.feature-ads.edit', $ad->id)}}" style="color:#fff"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('back.feature-ads.delete', $ad->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></a>
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
    </div> --}}

    {{-- <div class="col-md-12">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5>Banner</h5>
            </div>

            <div class="card-body" style="position: relative">
                @if($banner)
                    <img src="{{$banner->img_paths['original']}}" class="whp">

                    <div class="banner_btns">
                        <a class="btn btn-success btn-sm" href="{{route('back.feature-ads.edit', $banner->id)}}" style="color:#fff"><i class="fa fa-edit"></i></a>

                        <a href="{{route('back.feature-ads.delete', $banner->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></a>
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <button class="btn btn-success">Update position</button>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <script src="{{asset('back/js/jquery-sortable.js')}}"></script>
    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 400,
                filebrowserUploadUrl: "{{route('imageUpload')}}?"
            });
        });

        $(function () {
            $(".moveContent").sortable();
        });
    </script>
@endsection
