@extends('layout')
@section('content')
<h1>Login</h1>
<form method="POST" action="{{ route('submitLogin') }}">
    @csrf
    <input type="text" name="email" placeholder="email"/><br>
    <input type="text" name="password" placeholder="password"/><br>
    <input type="checkbox" name="rememberMe" id="rememberMe" />
    <label for="rememberMe">Remember Me</label><br>
    <button type="submit">Submit</button>
    <a href="{{ route('register') }}"><button type="button">Register</button>
    <a href="{{ route('register') }}"><button type="button">Forgot Password</button>
    <a href="{{ route('inventory') }}"><button type="button">Back to Inventory</button></a>
</form>
@endsection