@extends('Layout/layout')
@section('content')
@include('Layout/singleFormStyle')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Forgot Password
            </div>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('submitForgotPassword') }}">
            @csrf
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="envelope icon">
                        </i>
                        <input type="text" name="email" placeholder="Email Address">
                    </div>
                </div>
                <button class="ui button">
                    Submit
                </button>
                <div class="ui button" onclick="window.history.go(-1);">
                    Back
                </div>
            </div>
            <div class="ui error message"></div>
        </form>
    </div>
</div>
@endsection