@extends('back.layouts.master')
@section('title', 'Courier Config')

@section('head')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0
        }

        .slider {
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc
        }

        .slider,.slider:before {
            position: absolute;
            transition: .4s
        }

        .slider:before {
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 3px;
            background-color: #fff
        }

        input:checked+.slider {
            background-color: #258391
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #258391
        }

        input:checked+.slider:before {
            transform: translateX(26px)
        }
        .slider.round {
            border-radius: 34px
        }

        .slider.round:before {
            border-radius: 50%
        }
    </style>
@endsection

@section('master')
<form action="{{route('back.courier.update')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card border-light mt-3 shadow mb-3">
        <div class="card-header">
            <h5 class="d-inline-block mt-1 mb-0">Courier Config</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><b>Enable Courier</b></label>
                        <select name="enable_courier" class="form-control form-control-sm courier_status">
                            <option value="No" {{(($courier_config['enable_courier'] ?? 'No') == 'No') ? 'selected' : ''}}>Disabled</option>
                            <option value="Yes" {{(($courier_config['enable_courier'] ?? 'No') == 'Yes') ? 'selected' : ''}}>Enable</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="courier_inputs" style="display:{{(($courier_config['enable_courier'] ?? 'No') == 'Yes') ? 'block' : 'none'}}">
        <div class="card border-light mt-3 shadow mb-4">
            <div class="card-header">
                <h5 class="d-inline-block mt-1 mb-0">Pathao Credentials</h5>

                <label class="switch float-right"><input type="checkbox" class="appStatus" name="pathao_enabled" value="Yes" {{ (($courier_config['pathao_enabled'] ?? '') == 'Yes') ? 'checked' : '' }}><span class="slider round"></span></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Client ID</b></label>
                            <input type="text" class="form-control" name="pathao_client_id" value="{{$courier_config['pathao_client_id'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Client Secret</b></label>
                            <input type="password" class="form-control" name="pathao_client_secret" value="{{$courier_config['pathao_client_secret'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Username</b></label>
                            <input type="text" class="form-control" name="pathao_username" value="{{$courier_config['pathao_username'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Password</b></label>
                            <input type="password" class="form-control" name="pathao_password" value="{{$courier_config['pathao_password'] ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-light mt-3 shadow mb-4">
            <div class="card-header">
                <h5 class="d-inline-block mt-1 mb-0">REDX Credentials</h5>

                <label class="switch float-right"><input type="checkbox" class="appStatus" name="redx_enabled" value="Yes" {{ (($courier_config['redx_enabled'] ?? '') == 'Yes') ? 'checked' : '' }}><span class="slider round"></span></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>REDX API Token</b></label>
                            <input type="password" class="form-control" name="redx_api_token" value="{{$courier_config['redx_api_token'] ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-light mt-3 shadow mb-4">
            <div class="card-header">
                <h5 class="d-inline-block mt-1 mb-0">Steadfast Credentials</h5>

                <label class="switch float-right"><input type="checkbox" class="appStatus" name="steadfast_enabled" value="Yes" {{ (($courier_config['steadfast_enabled'] ?? '') == 'Yes') ? 'checked' : '' }}><span class="slider round"></span></label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><b>API Key</b></label>
                            <input type="text" class="form-control" name="steadfast_api_key" value="{{$courier_config['steadfast_api_key'] ?? ''}}">
                        </div>
                        <div class="form-group">
                            <label><b>Secret Key</b></label>
                            <input type="password" class="form-control" name="steadfast_secret_key" value="{{$courier_config['steadfast_secret_key'] ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-light mt-3 shadow mb-4">
        <div class="card-body">
            <button class="btn btn-success create_btn">Update</button>
            <br>
            <small><b>NB: *</b> marked are required field.</small>
        </div>
    </div>
</form>
@endsection

@section('footer')
    <script>
        $(document).on('change', '.courier_status', function(){
            let status = $(this).val();
            if(status == 'Yes'){
                $('.courier_inputs').show();
            }else{
                $('.courier_inputs').hide();
            }
        });
    </script>
@endsection
