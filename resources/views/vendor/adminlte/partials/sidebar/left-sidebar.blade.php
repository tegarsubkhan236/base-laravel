<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif
{{--    <div class="user-panel">--}}
{{--        <div class="image text-center">--}}
{{--            <img src="https://simita-is.unikom.ac.id/img.php?src=https://simita-is.unikom.ac.id/uploads/foto/peserta/10516236_w8SB8.jpg&amp;w=100&amp;h=100" class="img-circle" alt="User Image">--}}
{{--        </div>--}}
{{--    </div>--}}
    {{-- Sidebar menu --}}
    <div class="sidebar" style="height: auto">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{Auth::user()->avatar ? Auth::user()->avatar:"https://simita-is.unikom.ac.id/img.php?src=https://simita-is.unikom.ac.id/uploads/foto/peserta/10516236_w8SB8.jpg&amp;w=100&amp;h=100"}}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <p class="text-white d-block">{{Auth::user()->username}}</p>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
