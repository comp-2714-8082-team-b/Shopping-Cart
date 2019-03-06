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
@endsection