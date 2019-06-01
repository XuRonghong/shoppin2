
<header id="header">
    <div class="inner">
        <a href="index.html" class="logo">Theory</a>
        <nav id="nav">
            <form action="{{ route('logout') }}" method="post" id="layouts-nav-form">
                {{ csrf_field() }}
                <a href="index.html">Home</a>
                <a href="generic.html">Generic</a>
                <a href="elements.html">Elements</a>
                @if (Route::has('login'))
                    @if(Auth::guard('web')->check())
                        {{--<a href="{{ url('/home') }}">Home</a>--}}
                        <a onclick="document.getElementById('layouts-nav-form').submit();" href="#">Logout</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endAuth
                @endif
            </form>
        </nav>
        <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
    </div>
</header>