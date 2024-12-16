@extends('back.layouts.master')
@section('title', 'Edit Feature Ads')

@section('master')
<form action="{{route('back.feature-ads.update', $feature_ad->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Title</b></label>
                                <input type="text" class="form-control form-control-sm" name="title" value="{{old('title') ?? $feature_ad->title}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Custom Text*</b></label>

                                <textarea id="editor" class="form-control form-control-sm" name="description" cols="30" rows="3" required>{{old('description', $feature_ad->description)}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <img class="img-thumbnail uploaded_img" style="width: 50%;max-width: 220px" src="{{$feature_ad->img_paths['medium']}}">

                            <div class="form-group">
                                <label><b>Ad Image</b></label>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input image_upload" name="image" accept="image/*">
                                    <label class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
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
