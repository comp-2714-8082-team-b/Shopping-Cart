@extends('Layout/layout', ['showHeader' => false, 'title' => 'Login'])
@section('content')
@include('Layout/singleFormStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/login_background.css') }}">
<style>
/* Google Fonts */
@import url(https://fonts.googleapis.com/css?family=Anonymous+Pro);

.line-1{
    position: relative;
    top: 50%;  
    width: 24em;
    margin: 0 auto;
    border-right: 2px solid rgba(255,255,255,.75);
    font-size: 180%;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    transform: translateY(-50%);    
}

/* Animation */
.anim-typewriter{
  animation: typewriter 2s steps(35) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 11.5em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}
</style>
<section class="main">


<div class="absolute cloud_left">
    <ul class="inline-list">
      <li class="cloud"></li>
      <li class="cloud"></li>
      <li class="cloud"></li>
    </ul>
</div>

<div class="absolute cloud_right">
    <ul class="inline-list">
      <li class="cloud"></li>
      <li class="cloud"></li>
      <li class="cloud"></li>
    </ul>
</div>

<span class="absolute sun"></span>


<div class="absolute landscape left_m">

    <span class="grass gl">
        <span class="land_tree leftt-gras">
            <ul class="inline-list">
              <li class="t_grass"></li>
              <li class="t_grass"></li>
              <li class="t_grass"></li>
            </ul>
        </span>
    </span>

    <span class="absolute tree1"></span>
    <span class="absolute tree2"></span>
</div>

<div class="absolute landscape max_right">

    <span class="grass">
        <span class="land_tree">
            <ul class="inline-list">
              <li class="t_grass"></li>
              <li class="t_grass"></li>
              <li class="t_grass"></li>
            </ul>
        </span>
    </span>

    <div class="mountain">
        <div class="r-mountain"></div>
        <ul class="snow inline-list">
                <li></li>
                <li></li>
                <li></li>
        </ul>
    </div>

</div>

<div class="absolute boat">
    <ul class="no-bullet">
        <ul class="no-bullet fume">
            <li class="fume4"></li>
            <li class="fume3"></li>
            <li class="fume2"></li>
            <li class="fume1"></li>
        </ul>
        <li class="smokestack"></li>
        <li class="white-body">
            <ul class="windows inline-list">
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
            </ul>
        </li>
        <li class="boat-body"></li>
    </ul>
</div>

<div class="absolute dark-back"></div>

<div class="absolute plane">
    <ul class="no-bullet">
        <li class="plane-body">
            <ul class="windows inline-list">
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
            </ul>
        </li>

        <li class="wing1"></li>
        <li class="wing1 flipwing"></li>
        <li class="absolute teal"></li>
    </ul>
</div>

<div class="absolute sea">
    <span class="wave1"></span>
    <span class="wave2"></span>
    <span class="wave3"></span>
    <span class="wave4"></span>
</div>

</section>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="typewriter">
            <h1 class="line-1 anim-typewriter">Are you ready to Login??</h1>
        </div>
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
                <div class="fields">
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="rememberMe">
                            <label>Remember Me</label>
                        </div>
                    </div>
                    <div class="eleven wide field" style="text-align:right;">
                        <a href="{{ route('register') }}">Forgot my password</a>
                    </div>
                </div>
                <div class="ui fluid submit red button">
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
            New to us? <a href="{{ route('register') }}">Sign up</a>
        </div>
<!--        <div class="ui animated button" tabindex="0">
            <a href="{{ route('home') }}">
            <div class="visible content">Back</div>
            <div class="hidden content">
                <i class="right arrow icon"></i>
            </div>
            </a>
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
        </div>-->
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

    var i = 0;
    var txt = 'Login to {{ config('app.name', 'Laravel') }}'; /* The text */
    var speed = 50; /* The speed/duration of the effect in milliseconds */
    window.onload = function(){
        setTimeout(typeWriter(), speed);
    };
function typeWriter() {
  if (i < txt.length) {
    document.getElementById("typewriter").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}

</script>
@endsection