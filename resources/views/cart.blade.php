@extends('Layout/layout', ['showHeader' => true, 'title' => 'Home'])
@section('content')
@if (!$items)
<h1>You currently have no items</h1>
@else
@include('item', ['items' => $items])
@endif
@endsection