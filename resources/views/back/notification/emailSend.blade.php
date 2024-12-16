@extends('back.layouts.master')
@section('title', 'Send Email')

@section('head')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('master')
<form action="{{route('back.notification.emailSend')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card border-light mt-3 shadow">
        <div class="card-header no_icon">
            <a href="{{route('back.notification.email')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> Back</a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-block"><b>Select Status*</b></label>
                        <select name="status" class="form-control customer_status">
                            <option value="All Customer">All Customer</option>
                            <option value="Selected Customer" selected>Selected Customer</option>
                            <option value="Active Customer">Active Customer</option>
                            <option value="Suspended Customer">Suspended Customer</option>
                            <option value="Pending Customer">Pending Customer</option>
                            <option value="Newsletter Subscribers">Newsletter Subscribers</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 customer_select">
                    <div class="form-group">
                        <label class="d-block"><b>Select Customer*</b></label>
                        <select name="customers[]" class="form-control form-control-sm selectpicker" multiple>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label><b>Subject*</b></label>
                <input type="text" class="form-control form-control-sm" name="subject" value="{{old('subject')}}" required>
            </div>

            <div class="form-group">
                <label><b>Body*</b></label>

                <textarea id="editor" class="form-control form-control-sm" name="body" cols="30" rows="3" required>{{old('body')}}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-success">Submit</button>
            <br>
            <small><b>NB: *</b> marked are required field.</small>
        </div>
    </div>
</form>

{{-- <div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5>Newsletter Subscribers</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">SL.</th>
                <th scope="col">Email</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $key => $subscriber)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$subscriber->email}}</td>
                        <td class="text-right">
                            <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?');" href="{{route('back.notification.deleteNewslatter', $subscriber->id)}}"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 400
            });
        });

        // Select2
        $('.selectpicker').select2({
            placeholder: "Search Customer",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("back.customers.selectList") }}?type=customer',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $(document).on('change', '.customer_status', function(){
            let status = $(this).val();

            if(status == 'Selected Customer'){
                $('.customer_select').show();
            }else{
                $('.customer_select').hide();
            }
        });
    </script>
@endsection
