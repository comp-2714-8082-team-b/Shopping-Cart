@extends('Layout/layout', ['showHeader' => false, 'title' => 'Email Sent'])
@section('content')
@include('Layout/singleFormStyle')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Password Reset Link Sent
            </div>
        </h2>
        
        <div class="ui fluid large teal submit button">
            <a href="{{ route('home') }}" style="color:white;">
                   Back
            </a>
        </div>
    </div>
</div>
@endsection