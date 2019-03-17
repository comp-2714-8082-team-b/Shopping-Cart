<div class="ui top attached menu">
    <a href="./" class="item">
        {{ config('app.name', 'Laravel') }}
    </a>
    <div class="right menu">
        @if (\Auth::check())
    @if ((Auth::user()->type == "admin") || (Auth::user()->type == "master"))
        <a href="{{ route('inventory')}}" class="item">Inventory</a>
        <a href="{{ route('manageUsers')}}" class="item">Manage Users</a>
    @endif
        <a href="{{ route('cart') }}" class="item">
            <i class="shopping cart icon"></i>
        </a>
        @endif
        <div class="ui right aligned category search item">
            <div class="ui transparent icon input">
                <input class="prompt" type="text" placeholder="Search items...">
                <i class="search link icon"></i>
            </div>
            <div class="results"></div>
        </div>
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
