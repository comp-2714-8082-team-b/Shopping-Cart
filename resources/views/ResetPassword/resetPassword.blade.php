@extends('Layout/layout')
@section('content')
@include('Layout/singleFormStyle')
<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Reset Password
            </div>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('submitResetPassword', ['token' => $token]) }}" id="resetPasswordForm">
            @csrf
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon">
                        </i>
                        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon">
                        </i>
                        <input type="password" name="confirmPassword" placeholder="Confirm Password" value="{{ old('confirmPassword') }}">
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
    </div>
</div>

<script>
    $("#resetPasswordForm")
        .form({
            fields: {
                password: {
                    identifier: 'password',
                    rules: [
                        {
                            type   : 'empty',
                             prompt : 'Please enter your password'
                        },
                        {
                            type   : 'minLength[6]',
                             prompt : 'Password must be at least 6 characters long'
                        },
                        {
                            type   : 'maxLength[20]',
                             prompt : 'Please must be less than 20 characters long'
                        }
                    ]
                },
                conFirmpassword: {
                    identifier: 'confirmPassword',
                    rules: [
                        {
                            type   : 'empty',
                             prompt : 'Please enter your password again'
                        },
                        {
                            type   : 'match[password]',
                            prompt : 'The password entered do not match'
                        }
                    ]
                },
            }
        })
    ;
</script>
@endsection