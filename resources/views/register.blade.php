@extends('Layout/layout', ['showHeader' => false, 'title' => 'Register'])
@section('content')
@include('Layout/singleFormStyle')
<div class="ui middle aligned center aligned grid style fade-in">
    <div class="column">             
    <h1> Register</h1>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('submitRegister') }}" id="registerForm">
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
                        <i class="user icon">
                        </i>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                </div>
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
                        <input type="password" name="conFirmpassword" placeholder="Confirm Password" value="{{ old('conFirmpassword') }}">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="address card icon">
                        </i>
                        <input type="text" name="firstName" placeholder="First Name" value="{{ old('firstName') }}">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="address card icon">
                        </i>
                        <input type="text" name="lastName" placeholder="Last Name" value="{{ old('lastName') }}">
                    </div>
                </div>

                <div class="ui fluid large submit button">
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
            <div class="ui large button">
                Back
            </div>
        </a>
    </div>
</div>
<script>
    $("#registerForm").form({
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
            username: {
                identifier: 'username',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please enter your username'
                    }
                ]
            },
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
                identifier: 'conFirmpassword',
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
            firstName: {
                identifier: 'firstName',
                rules: [
                    {
                        type   : 'empty',
                        prompt : 'Please enter your first name'
                    },
                    {
                        type   : 'maxLength[63]',
                        prompt : 'Your first name cannot be more than 63 characters'
                    }
                ]
            },
            lastName: {
                identifier: 'lastName',
                rules: [
                    {
                        type   : 'maxLength[63]',
                        prompt : 'Your last name cannot be more than 63 characters'
                    }
                ]
            },
        }
    });
    
</script>
@endsection
