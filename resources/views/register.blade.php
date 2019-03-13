@extends('Layout/layout')
@section('content')
@include('Layout/singleFormStyle')
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