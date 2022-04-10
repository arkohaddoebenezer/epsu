<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        {{-- <div class="navbar-logo">
            <a href="/" id="mobile-collapse">
                <img class="img-fluid mb-3 d-block d-md-none" height="50%" src="{{ asset('img/logo-head.png') }}"
                    alt="Theme-Logo" />

                <img class="img-fluid mb-3 d-none d-md-block" src="{{ asset('img/logo-head.png') }}"
                    alt="Theme-Logo" />
            </a>

            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div> --}}
        <div class="navbar-logo">
            <a href="{{ config('app.url')}}">
                <img class="img-fluid d-md-block d-sm-block d-none" src="{{ asset('img/GESAM1.png') }}" width="60%" height="50%"  alt="Theme-Logo" />
                <h4 class="img-fluid d-block d-md-none d-sm-none">EPSU NATIONAL</h4>
                 
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu icon-toggle-right"></i>
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <a href="#!"
                        onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()"
                        class="waves-effect waves-light" data-cf-modified-74c861d567cfff2a69398b65-="">
                        <i class="full-screen feather icon-maximize"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('img/avatar-placeholder.png') }}" class="img-radius"
                                alt="User-Profile-Image">
                            <span>{{ Auth::user()->name}}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <a style="cursor: pointer;" data-toggle="modal" data-target='#changePasswordModal1'>
                                    <i class="feather icon-lock"></i> Change Password
                                </a>
                            </li>
                            <li>
                                <a style="cursor:pointer"
                                    onclick="event.preventDefault(); document.forms['logout-form'].submit()">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form" method="POST" hidden>
                                    @csrf
                                </form>
                            </li>
                            {{-- <li>
                                <a style="cursor: pointer;" data-toggle="modal" data-target='#changePasswordModal1'>
                                    <i class="feather icon-lock"></i> Suspend Voting
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include("auth.change-password")
