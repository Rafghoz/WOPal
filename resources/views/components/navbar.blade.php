<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="/"><img src="{{ asset('UI/img/logo.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto" id="menuNav">
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item {{ request()->is('WO') ? 'active' : '' }}"><a class="nav-link" href="/WO">Wedding Organizer</a></li>
                        <li class="nav-item {{ request()->is('AboutUs') ? 'active' : '' }}"><a class="nav-link" href="/AboutUs">Tentang Kami</a></li>
                        <li class="nav-item {{ request()->is('Bergabung') ? 'active' : '' }}"><a class="nav-link" href="/Bergabung">Bergabung</a></li>
                        
                        @if (auth()->check())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ auth()->user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/cms/edit-user">Profile Akun</a>
            <a class="dropdown-item" href="/logout">Log out</a>
        </div>
    </li>
@else
    <li class="nav-item {{ request()->is('login') ? 'active' : '' }}">
        <a class="nav-link" href="/login">Log in</a>
    </li>
@endif

                        {{-- <li class="nav-item {{ request()->is('login') ? 'active' : '' }}" id="authLink"><a class="nav-link" href="/login">Log in</a></li> --}}
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

