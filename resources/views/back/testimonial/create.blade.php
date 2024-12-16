@extends('back.layouts.master')
@section('title', 'Create Testimonial')

@section('master')
<form action="{{route('back.testimonials.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-header no_icon">
                    <a href="{{route('back.testimonials.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Client Name*</b></label>
                                <input type="text" class="form-control form-control-sm" name="client_name" value="{{old('client_name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Testimonial*</b></label>

                                <textarea class="form-control form-control-sm" name="testimonial" cols="30" rows="3" required>{{old('testimonial')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="img_group">
                                    <img class="img-thumbnail uploaded_img" src="{{asset('img/default-img.png')}}">

                                    <div class="form-group text-center">
                                        <label><b>Client Logo*</b></label>
                                        <div class="custom-file text-left">
                                            <input type="file" class="custom-file-input image_upload" required accept="image/*" name="image">
                                            <label class="custom-file-label">Choose file...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Position*</b></label>

                                <input type="number" class="form-control form-control-sm" name="position" value="{{old('position')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Create</button>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
