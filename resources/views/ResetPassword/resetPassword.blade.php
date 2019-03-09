@extends('layout')
@section('content')
<h1>PReset Password</h1>
<form method="POST" action="{{ route('') }}"
      @csrf
    <input type="password" placeholder="password" name="newPassword"/>
    <input type="password" placeholder="password" name="confirmationPassword"/>
</form>
@endsection