@extends('Layout/layout', ['showHeader' => true, 'title' => 'Item Description'])
@section('content')
<h1>{{$item->itemName}}</h1>
@endsection
