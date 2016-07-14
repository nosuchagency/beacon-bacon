@if (! Auth::guest())
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
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

        <!-- Sidebar Menu -->
        @include('custom-menu')
        <br /><br />
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
@endif