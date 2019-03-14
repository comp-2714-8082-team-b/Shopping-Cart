@extends('Layout/layout')
@include('Layout/header')
@section('content')
@for ($i = 0; $i < 10; $i++)
    @if ($itemsInCart["modelNumber" . $i])
    <p>{{ $itemsInCart["modelNumber" . $i] }}
    @endif
@endfor
@endsection