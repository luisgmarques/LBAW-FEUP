<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-header py-2">
        <div class="container">

            <a class="navbar-brand py-0" href="{{ URL::to('/') }}">
                <img src="{{ asset('images/upa_logo-dark.png') }}" alt="logo" width="180">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form id="search" method="GET" action="{{ route('search') }}">
                    <div class="input-group form-row">
                        <input id="search-placeholder" name="query" type="search" class="form-control"
                            placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary"><i
                                    class="fas fa-search text-accent"></i></button>
                        </div>
                    </div>
                </form>
                @auth
                <div class="navbar-nav d-flex align-items-center ml-auto" id="notifications-header">
                    <ul class="nav-item" id="navbar-rightside">
                        <li class="">
                            @if (auth()->user()->is_admin)
                            <form class="nav-link text-card-text" style="display: inline" action="{{ route('admin') }}" method="GET">
                                <button class="btn btn-outline-secondary px-4" type="submit">Admin</button>
                            </form>
                            @else
                            <form class="nav-link text-card-text" style="display: inline" action="{{ route('auction.create') }}" method="GET">
                                <button class="btn btn-outline-secondary px-4" type="submit">Sell</button>
                            </form>
                            @endif
                        </li>
                        <li class="">
                            <a class="nav-link text-secondary" href="{{ route('messages.index') }}">
                                <i class="fas fa-envelope fa-lg"></i>
                            </a>
                        </li>
                        <li class="">
                            <a class="nav-link text-secondary" href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell fa-lg"></i>
                            </a>
                        </li>
                        <li class="">
                            <a class="nav-link text-secondary" href="{{ route('wishlist.index') }}">
                                <i class="fas fa-heart fa-lg"></i>
                            </a>
                        </li>
                        <li class="">
                            <div class="dropdown">
                                <a class="nav-link text-secondary" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" id="dropdownMenu2" href="#">
                                    <i class="fas fa-user fa-lg"></i>
                                </a>
                                <div class="dropdown-menu mb-1" aria-labelledby="dropdownMenu2" id="user-menu">
                                    <a class="dropdown-item"
                                        href="/profile/{{ auth()->user()->id }}">Personal
                                        Information</a>
                                    <a class="dropdown-item"
                                        href=" {{ route('wishlist.index') }}">Wishlist</a>
                                    <a class="dropdown-item"
                                        href="{{ route('notifications.index') }}">Notifications</a>
                                    <a class="dropdown-item"
                                        href=" {{ route('messages.index') }}">Messages</a>
                                    <div class="dropdown-divider my-0"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                @endauth
                @guest
                <div class="navbar-nav d-flex align-items-center ml-auto" id="notifications-header">
                    <ul class="nav-item" id="navbar-rightside">
                        <li class="">
                            <a class="nav-link text-card-text" href="{{ route('login') }}">Sign In</a>
                        </li>
                        <li class="">
                            <a class="nav-link text-card-text" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    </ul>
                </div>
                @endguest
            </div>
        </div>
    </nav>
</header>