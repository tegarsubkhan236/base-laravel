<!-- Main Sidebar -->
<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
    <div class="main-navbar">
        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
            <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                    <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="{{asset('assets/images/shards-dashboards-logo.svg')}}" alt="Shards Dashboard">
                    <span class="d-none d-md-inline ml-1">Laravel Boilerplate</span>
                </div>
            </a>
            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </nav>
    </div>
    <div class="nav-wrapper">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('dashboard')}}">
                    <i class="material-icons">edit</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap"  data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">vertical_split</i>
                    <span>Blog Posts</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="user-profile-lite.html">
                        <i class="material-icons">&#xE7FD;</i> Profile</a>
                    <a class="dropdown-item" href="#">
                        <i class="material-icons">&#xE879;</i> Logout </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('profile')}}">
                    <i class="material-icons">person</i>
                    <span>User Profile</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- End Main Sidebar -->
