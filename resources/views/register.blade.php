@extends('Layout/layout')
@section('content')
@include('Layout/singleFormStyle')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/login_background.css') }}">
<style>
.fade-in {
  animation: fadeIn ease 5s;
  -webkit-animation: fadeIn ease 5s;
  -moz-animation: fadeIn ease 5s;
  -o-animation: fadeIn ease 5s;
  -ms-animation: fadeIn ease 5s;
}


@keyframes fadeIn{
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

@-moz-keyframes fadeIn {
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

@-webkit-keyframes fadeIn {
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

@-o-keyframes fadeIn {
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

@-ms-keyframes fadeIn {
  0% {
    opacity:0;
  }
  100% {
    opacity:1;
  }
}

/* The style below is just for the appearance of the example div */

.style {
  text-align:center;
  padding-top:calc(50vh - 50px);
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
