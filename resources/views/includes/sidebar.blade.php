<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <ul class="pcoded-item pcoded-left-item">
                <li class="@if (Route::currentRouteName()==='dashboard' ) active @endif">
                    <a href="{{ config('app.url') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                    <li class="@if (Route::currentRouteName()==='presbyteries' ) active @endif">
                        <a href="{{ config('app.url') }}/presbyteries" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-university"></i>
                            </span>
                            <span class="pcoded-mtext">Presbyteries</span>
                        </a>
                    </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national','presbytery']))
                <li class="@if (Route::currentRouteName()==='districts' ) active @endif">
                    <a href="{{ config('app.url') }}/districts" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-list"></i>
                        </span>
                        <span class="pcoded-mtext">Districts</span>
                    </a>
                </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national','presbytery','district']))
                <li class="@if (Route::currentRouteName()==='branches' ) active @endif">
                    <a href="{{ config('app.url') }}/branches" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-object-ungroup"></i>
                        </span>
                        <span class="pcoded-mtext">Branches</span>
                    </a>
                </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national','presbytery','district','branch']))
                <li class="@if (Route::currentRouteName()==='unions' ) active @endif">
                    <a href="{{ config('app.url') }}/unions" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-balance-scale"></i>
                        </span>
                        <span class="pcoded-mtext">Unions</span>
                    </a>
                </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='institutions' ) active @endif">
                    <a href="{{ config('app.url') }}/institutions" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-university"></i>
                        </span>
                        <span class="pcoded-mtext">Institutions</span>
                    </a>
                </li>
                @endif
                <li class="@if (Route::currentRouteName()==='members' ) active @endif">
                    <a href="{{ config('app.url') }}/members" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="pcoded-mtext">Members</span>
                    </a>
                </li>
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='groups' ) active @endif">
                    <a href="{{ config('app.url') }}/groups" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-compass"></i>
                        </span>
                        <span class="pcoded-mtext">Professional Groups</span>
                    </a>
                </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='professional_members' ) active @endif">
                    <a href="{{ config('app.url') }}/professional_members" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="pcoded-mtext">Professional Members</span>
                    </a>
                </li>
                @endif
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='congress' ) active @endif">
                    <a href="{{ config('app.url') }}/congress" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cubes"></i>
                        </span>
                        <span class="pcoded-mtext">Congresses</span>
                    </a>
                </li>
                @endif
                <li class="@if (Route::currentRouteName()==='congress_members' ) active @endif">
                    <a href="{{ config('app.url') }}/congress_members" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="pcoded-mtext">Congress Members</span>
                    </a>
                </li>
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='executives' ) active @endif">
                    <a href="{{ config('app.url') }}/executives" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-briefcase"></i>
                        </span>
                        <span class="pcoded-mtext">Executives</span>
                    </a>
                </li>
                <li class="@if (Route::currentRouteName()==='council' ) active @endif">
                    <a href="{{ config('app.url') }}/council" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="pcoded-mtext">Council Members</span>
                    </a>
                </li>
                @endif
                <li class="@if (Route::currentRouteName()==='messages' ) active @endif">
                    <a href="{{ config('app.url') }}/messaging" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-comments"></i>
                        </span>
                        <span class="pcoded-mtext">Messaging</span>
                    </a>
                </li>
                @if (in_array(strtolower(Auth::user()->usertype), ['national']))
                <li class="@if (Route::currentRouteName()==='users' ) active @endif">
                    <a href="{{ config('app.url') }}/users" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-user-secret"></i>
                        </span>
                        <span class="pcoded-mtext">Users</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
