<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                    <a href="{{ route('owner.dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="{{ (request()->segment(2) == 'users') ? 'active' : '' }}">
                    <a href="{{ route('owner.users') }}"><i class="menu-icon fa fa-users"></i>Users </a>
                </li>
                <li class="{{ (request()->segment(2) == 'owners') ? 'active' : '' }}">
                    <a href="{{ route('owners') }}"><i class="menu-icon fa fa-users"></i>Admins </a>
                </li>
                {{-- <li class="menu-item-has-children dropdown {{ (request()->segment(2) == 'plans') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-dollar"></i>Subscription Plans </a>
                    <ul class="sub-menu children dropdown-menu">                            
                        <li><i class="fa fa-eye"></i><a href="{{ url('owner/plans') }}">View Plans</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ url('owner/plan/new') }}">Add New Plan</a></li>
                    </ul>
                </li> --}}
                <li class="{{ (request()->segment(2) == 'plans') ? 'active' : '' }}">
                    <a href="{{ route('owner.plans') }}"><i class="menu-icon fa fa-list"></i> View Plans </a>
                </li>
                <li class="{{ (request()->segment(2) == 'stripe') ? 'active' : '' }}">
                    <a href="{{ route('owner.stripe') }}"><i class="menu-icon fa fa-list"></i> Transactions </a>
                </li>
                <li class="{{ (request()->segment(3) == 'stripe') ? 'active' : '' }}">
                    <a href="{{ route('owner.app.settings', 'stripe') }}">
                        <i class="menu-icon fa fa-skype"></i>Stripe
                    </a>
                </li>
                <li class="{{ (request()->segment(3) == 'twilio') ? 'active' : '' }}">
                    <a href="{{ route('owner.app.settings', 'twilio') }}">
                        <i class="menu-icon fa fa-envelope"></i>Twilio SMS
                    </a>
                </li>
                <li class="{{ (request()->segment(3) == 'smtp') ? 'active' : '' }}">
                    <a href="{{ route('owner.app.settings', 'smtp') }}">
                        <i class="menu-icon fa fa-envelope"></i>SMTP
                    </a>
                </li>
                <li class="{{ (request()->segment(3) == 'web') ? 'active' : '' }}">
                    <a href="{{ route('owner.app.settings', 'web') }}">
                        <i class="menu-icon fa fa-cog"></i>Settings
                    </a>
                </li>
                <li class="{{ (request()->segment(2) == 'slider') ? 'active' : '' }}">
                    <a href="{{ route('slider.index') }}">
                        <i class="menu-icon fa fa-cog"></i>Sliders
                    </a>
                </li>
                {{-- <li class="{{ (request()->segment(2) == 'about') ? 'active' : '' }}">
                    <a href="{{ route('owner.app.about') }}">
                        <i class="menu-icon fa fa-building-o"></i>About
                    </a>
                </li> --}}
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>