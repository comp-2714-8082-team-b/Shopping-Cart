@extends('layout')
@section('content')
<h1>Forgot Password</h1>
<form method="POST" action="{{ route('submitForgotPassword') }}">
    @csrf
    <input type="text" name="email" placeholder="email"/><br>
    <button type="submit">Submit</button>
    <button type="button" onclick="window.history.go(-1);">Back</button>
</form>
@endsection