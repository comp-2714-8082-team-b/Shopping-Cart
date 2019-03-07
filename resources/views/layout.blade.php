<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name') }} | {{ $data['title'] }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/app.css') }}">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="{{ asset('public/semanticUI/semantic/out/semantic.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/semantic.min.css') }}">
    </head>
    <body>
        @yield('semantic') 
        @yield('content')
    </body>
</html>
