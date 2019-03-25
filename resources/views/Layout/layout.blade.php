<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name') }} | {{ $title }}</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('public/css/app.css') }}">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/dropdown.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/segment.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/form.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/input.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/button.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/list.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/message.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('public/semanticUI/semantic/out/components/icon.css') }}">
        <script src="{{ asset('public/semanticUI/semantic/out/components/form.js') }}"></script>
        <script src="{{ asset('public/semanticUI/semantic/out/components/transition.js') }}"></script>
        <script src="{{ asset('public/semanticUI/semantic/out/components/dropdown.js') }}"></script>
        <script src="{{ asset('public/js/jquery.particleground.min.js') }}"></script>
        <script>
            $('.ui.sidebar').sidebar('toggle');
            function shortenItemDescriptions()
            {
                $(".description").css('max-height', (parseInt($('.square.image').css('height'), 10) / 2));
            }
            function updateTotalInCart()
            {
                $.ajax({
                    url: "{{ route('getTotal') }}",
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response != 0)
                            $("#totalInCart").html("$" + response);
                        else
                            $("#totalInCart").html("$0.00");
                    }
                });
            }
            $(document).ready(function () {
                $('#background').particleground({
                    dotColor: '#F4BEBE',
                    lineColor: '#BCDAF0',
                    particleRadius: 10,
                    density: 10000,
                    maxSpeedX: 0.4,
                    maxSpeedY: 0.4
                });
                $("#Logo").css('height', $(".right.menu .item").height() * 1.75);
                $("#Logo").css('width', 'auto');
                updateTotalInCart();
            });
        </script>
    </head>
    <body>
        @if ($showHeader)
            <div class="ui top attached menu large stackable inverted">
                <a href="{{ route('home') }}" class="item">
                    <img src="{{ asset('public/img/Logo-2.png') }}" id="Logo" />
                </a>
                <div class="right menu">
                    @if (\Auth::check())
                @if ((Auth::user()->type == "admin") || (Auth::user()->type == "master"))
                    <a href="{{ route('itemForm')}}" class="item">Create Item</a>
                    <a href="{{ route('manageUsers')}}" class="item">Manage Users</a>
                @endif
                    <a href="{{ route('cart') }}" class="item">
                        <i class="shopping cart icon"></i><span id="totalInCart"></span>
                    </a>
                    @endif
                    <form class="ui right aligned category search item" method="POST" action="{{ route('home') }}">
                        @csrf
                        <div class="ui transparent icon input inverted">
                            <input class="prompt" type="text" placeholder="Search items..." name="searchKey">
                            <i class="search link inverted icon"></i>
                        </div>
                        <div class="results"></div>
                    </form>
                    @if (\Auth::check())
                    <a href="{{ route('logout')}}" class="item">Logout</a>
                    @else
                    <a href="{{ route('login')}}" class="item">Login</a>
                    @endif
                </div>
            </div>
            <div class="ui bottom attached segment">
                <p></p>
            </div>
        <span id="background" style="position: fixed;z-index: -1;width:100%;height:100%;"></span>
        <div class="ui container segment">
        @yield('content')
        </div>
        <div class="ui inverted vertical footer segment">
            <div class="ui right aligned container">
                <div class="ui horizontal inverted small divided link list">
                    <p class="item">Made By: Davin, Greg, Ken, Pamir</p>
                </div>
            </div>
        </div>
        @else
        @yield('content')
        @endif
    </body>
</html>
