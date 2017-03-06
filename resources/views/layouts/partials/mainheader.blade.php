<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>B</b>A</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{__('Bacon')}}</b>{{__('Admin')}}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{__('Toggle navigation')}}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{__('Register')}}</a></li>
                    <li><a href="{{ url('/login') }}">{{__('Login')}}</a></li>
                @else
                    {{--@if(Auth::user()->teams()->count() > 1)
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                          <i class="fa fa-users"></i>
                          <span class="label label-danger">{{ Auth::user()->teams()->count() }}</span>
                        </a>
                        <ul class="dropdown-menu">
                          <li class="header">You have {{ Auth::user()->teams()->count() }} teams</li>
                          <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                              @foreach(Auth::user()->teams as $team)
                              <li>
                                <a href="{{ route('teams.switch', $team->id) }}">
                                  <i class="fa fa-circle-o text-aqua"></i> {{ $team->name }}
                                </a>
                              @endforeach
                              </li>
                            </ul>
                          </li>
                          <li class="footer"><a href="{{ route('teams.index') }}">View all</a></li>
                        </ul>
                      </li>
                      @endif--}}
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('/img/avatar5.png')}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('/img/avatar5.png')}}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>{{__('Login')}} {{ date('j. F Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('profile') }}" class="btn btn-default btn-flat">{{__('Profile')}}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{__('Sign out')}}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
