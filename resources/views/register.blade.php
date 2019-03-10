@extends('layout')
@section('content')
<h1>Register</h1>
<form method="POST" action="{{ route('submitRegister') }}">
    @csrf
    <input type="text" name="email" placeholder="email"/><br>
    <input type="text" name="username" placeholder="username"/><br>
    <input type="text" name="password" placeholder="password"/><br>
    <input type="text" name="firstName" placeholder="First Name"/><br>
    <input type="text" name="lastName" placeholder="Last Name"/><br>
    <button type="submit">Submit</button>
    <button type="button" onclick="window.history.go(-1);">Back</button>
</form>

<style type="text/css">
    body {
      background-color: white;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }

    button {
        background: none;
	    color: inherit;
	    border: none;
	    padding: 0;
	    font: inherit;
	    cursor: pointer;
	    outline: inherit;
    }

</style>

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
                        <i class="user icon">
                        </i>
                        <input type="text" name="email" placeholder="Email Address">
                    </div>
                </div>
                <button class="ui button">
                    Submit
                </button>
                <button type="button" onclick="window.history.go(-1);">
                    Back
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
    </div>
</div>
@endsection