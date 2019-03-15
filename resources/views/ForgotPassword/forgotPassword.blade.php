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
        <form class="ui large form" method="POST" action="{{ route('submitForgotPassword') }}" id="forgotPasswordForm">
            @csrf
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="envelope icon">
                        </i>
                        <input type="text" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="ui fluid large teal submit button">
                    <button type="submit">
                        Submit
                    </button>
                </div>
            </div>
            <div class="ui error message"></div>
            @if ($errors->any())
                <div class="ui red message">
                    {!! implode('', $errors->all(':message</br>')) !!}
                </div>
            @endif
        </form>
        <a href="{{ route('login') }}" >
            <div class="ui button">
                Back
            </div>
        </a>
    </div>
</div>
<script>
    $("#forgotPasswordForm").form({
        fields: {
            email: {
                identifier: 'email',
                rules: [
                    {
                        type: 'empty',
                        prompt : 'Please enter your email'
                    },
                    {
                        type: 'email',
                        prompt: 'Email must be valid'
                    },
                    {
                        type: 'maxLength[127]',
                        prompt: 'Email cannot be longer than 127 characters'
                    }
                ]
            },
        }
    });
</script>
@endsection