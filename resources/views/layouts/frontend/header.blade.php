<header>
        <div class="container-fluid position-relative no-side-padding">

            <a href="{{ route('home') }}" style="width: 50px;" class="logo"><img src="{{ asset('assets/frontend') }}/images/logo.png" alt="Logo Image"></a>

            <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

            <ul class="main-menu visible-on-click" id="main-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('post.index') }}">All Post</a></li>
                <li><a href="#">Categories</a></li>
                @guest()
                <li><a href="{{ route('login') }}">Login</a></li>
                @else
                @if (Auth::user()->role_id == 1)
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @endif
                @if (Auth::user()->role_id == 2)
                <li><a href="{{ route('author.dashboard') }}">Dashboard</a></li>
                @endif

                @endguest
            </ul><!-- main-menu -->

            <div class="src-area">
                <form action='{{ route('search') }}' method="get">
                    <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                    <input name="query" value="{{ old('query') }}" class="src-input" type="text" placeholder="Type of search" style="padding: 18px; margin-left: 50px;">
                </form>
            </div>

        </div><!-- conatiner -->
    </header>