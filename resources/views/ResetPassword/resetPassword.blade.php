@extends('layout')
@section('content')
<h1>Reset Password</h1>
<form method="POST" action="{{ route('submitResetPassword', ['token' => $token]) }}">
    @csrf
    <input type="password" placeholder="password" name="newPassword"/><br>
    <input type="password" placeholder="confirm password" name="confirmationPassword"/><br>
    <button type="submit">Submit</button>
</form>
@endsection