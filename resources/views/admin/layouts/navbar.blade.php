<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" id="sidebar-collapse-button" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user-circle fa-2x"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();" class="dropdown-item">
                        {{ trans('auth.logout') }}
                    </a>
                </form>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-language fa-2x"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('locale.set', 'en') }}" class="dropdown-item">
                    English
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('locale.set', 'bn') }}" class="dropdown-item">
                    বাংলা
                </a>
            </div>
        </li>
    </ul>
</nav>
