@extends('Layout/layout')
@section('content')
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
                Register
            </div>
        </h2>
        <form class="ui large form" method="POST" action="{{ route('submitRegister') }}">
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
                        <i class="user icon">
                        </i>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon">
                        </i>
                        <input type="text" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="hourglass start icon">
                        </i>
                        <input type="text" name="firstName" placeholder="First Name">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="hourglass end icon">
                        </i>
                        <input type="text" name="lastName" placeholder="Last Name">
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