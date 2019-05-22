
<!-- Header -->
<header id="header">
    <a class="logo" href="index.html">Industrious</a>
    <nav>
        <a href="#menu">Menu</a>
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif
    </nav>
</header>