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
        <form class="ui large form" method="POST" action="{{ route('submitLogin') }}">
            @csrf
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="envelope icon">
                        </i>
                        <input type="text" name="email" placeholder="Email Address">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon">
                        </i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="ui fluid large teal submit button">
                    <button type="submit">
                        Submit
                    </button>
                </div>
            </div>
            <div class="ui error message"></div>
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
                <div class="visible content">Reset Password</div>
                <div class="hidden content">
                    <i class="right arrow icon"></i>
                </div>
                </a>
            </div>
</div>

<!-- 






<h1>Login</h1>
<form method="POST" action="{{ route('submitLogin') }}">
    @csrf
    <input type="text" name="email" placeholder="email"/><br>
    <input type="text" name="password" placeholder="password"/><br>
    <input type="checkbox" name="rememberMe" id="rememberMe" />
    <label for="rememberMe">Remember Me</label><br>
    <button type="submit">Submit</button>
    <a href="{{ route('register') }}"><button type="button">Register</button>
    <a href="{{ route('forgotPassword') }}"><button type="button">Forgot Password</button>
    <a href="{{ route('inventory') }}"><button type="button">Back to Inventory</button></a>
</form> -->
@endsection