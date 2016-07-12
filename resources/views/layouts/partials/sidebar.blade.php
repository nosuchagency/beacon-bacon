<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/avatar5.png')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> online</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}"><a href="{{ route('home') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>

            @if(Auth::user()->teams()->count() <> 1)
            <li class="{{ starts_with(Route::currentRouteName(), 'teams') ? 'active' : '' }}"><a href="{{ route('teams.index') }}"><i class="fa fa-users"></i> Teams</a></li>
            @endif

            @if(Auth::user()->isOwnerOfCurrentTeam())
            <li class="{{ starts_with(Route::currentRouteName(), 'users') ? 'active' : '' }}"><a href="{{ route('teams.members.show') }}"><i class="fa fa-users"></i> Users</a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
