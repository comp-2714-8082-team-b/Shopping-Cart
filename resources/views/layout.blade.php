<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name') }} | {{ $data['title'] }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/app.css') }}">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('public/semanticUI/semantic/out/semantic.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/semantic.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/reset.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/site.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/container.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/grid.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/header.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/image.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/divider.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/segment.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/form.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/input.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/button.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/list.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/message.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/icon.css') }}">
        <script src="{{ asset('public/semanticUI/semantic/out/components/form.js') }}"></script>
        <script src="{{ asset('public/semanticUI/semantic/out/components/transition.js') }}"></script>
        <style>
                #container{
        width: 70%;
        min-width: 1000px;
        margin: auto;
    }
    #left {
        float: left;
        width: 20%;
        background: #ccc;
    }
    #content {
        float: left;
        width: 60%;
        background: #ff0;        
    }
    #right {
        float: right;
        width: 20%;
        background: #ccc;
    }
        </style>
    </head>
    <body>
        <!-- @yield('semantic')  -->
        @yield('content')
    </body>
</html>
