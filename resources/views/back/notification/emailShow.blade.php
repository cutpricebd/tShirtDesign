@extends('back.layouts.master')
@section('title', 'Email Details')

@section('master')
<form action="{{route('back.notification.emailSend')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card border-light mt-3 shadow">
        <div class="card-header no_icon">
            <a href="{{route('back.notification.email')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> Back</a>
        </div>
        
        <div class="card-body">
            <h5>Date</h5>
            <p>{{date('d/m/Y', strtotime($email->created_at))}}</p>

            <h5>Emails</h5>
            <p>{{implode(',', $email->emails)}}</p>

            <h5>Subject</h5>
            <p>{{$email->subject}}</p>

            <hr>
            {{-- <h3>Body</h3> --}}
            <p>{!! $email->body !!}</p>
        </div>
    </div>
</form>
@endsection
