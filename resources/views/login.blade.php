@extends('Layout/layout')
@section('content')
@include('Layout/singleFormStyle')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Log-in to your account 
            </div>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('submitLogin') }}" id="loginForm">
            @csrf
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="envelope icon">
                        </i>
                        <input type="text" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon">
                        </i>
                        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
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
        <div class="ui message">
            <div class="ui checkbox">
                <input type="checkbox" name="example">
                <label>Remember Me</label>
            </div>
        </div>

        <div class="ui animated button" tabindex="0">
            <a href="{{ route('register') }}">
            <div class="visible content">Register</div>
            <div class="hidden content">
                <i class="right arrow icon"></i>
            </div>
            </a>
        </div>
        <div class="ui animated button" tabindex="0">
            <a href="{{ route('forgotPassword') }}">
            <div class="visible content">Forgot Password</div>
            <div class="hidden content">
                <i class="right arrow icon"></i>
            </div>
            </a>
        </div>
    </div>
</div>

<script>
    $("#loginForm")
        .form({
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
                password: {
                    identifier: 'password',
                    rules: [
                        {
                            type   : 'empty',
                             prompt : 'Please enter your password'
                        }
                    ]
                },
            }
        })
    ;
</script>
@endsection