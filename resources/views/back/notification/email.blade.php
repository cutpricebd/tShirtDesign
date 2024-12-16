@extends('back.layouts.master')
@section('title', 'Email Notification')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Email list</h5>

        <a href="{{route('back.notification.emailSend')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> New Mail</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Subject</th>
                {{-- <th scope="col">Emails</th> --}}
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($emails as $email)
                    <tr>
                        <th scope="row">{{$email->id}}</th>
                        <td>{{date('d/m/Y', strtotime($email->created_at))}}</td>
                        <td>{{$email->subject}}</td>
                        {{-- <td>{{implode(',', $email->emails)}}</td> --}}
                        <td class="text-right">
                            <a class="btn btn-sm btn-success" href="{{route('back.notification.emailShow', $email->id)}}">Details</a>
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
            order: [[0, "desc"]],
        });
    });
</script>
@endsection
