<!--
    Helper classes

    Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
    Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

    Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
    Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
        - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
-->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15" style="background: url('{{ asset('/image/logo.png') }}') no-repeat center center; background-size: 230px auto">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    {{-- <a class="link-effect font-w700" href="/">
                        <i class="si si-fire text-primary"></i>
                        <span class="font-size-xl text-dual-primary-dark">code</span><span class="font-size-xl text-primary">base</span>
                    </a> --}}
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side User -->
            @livewire('side-user')
            <!-- END Side User -->

            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">            
                @foreach($menuData as $value)
                    <li class="{{ request()->is('backend/'.$value['active']) ? ' open' : '' }}">
                        @if(isset($value['child'])) 
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="{{ $value['icon'] }}"></i>
                            <span class="sidebar-mini-hide">{{ __("backend.menu.{$value['title']}") }}</span>
                        </a>                  
                        <ul>                                                    
                            @foreach($value['child'] as $sub_value)
                                @if(in_array('read '.$sub_value['name'], $permissions) || auth()->user()->super_admin)
                                <li>
                                    <a class="{{ 
                                        request()->is('backend/'.$sub_value['active']) || request()->is('backend/'.$sub_value['active'].'/*') ? ' active' : '' 
                                    }}" href="{{ route('backend.'.$sub_value['name'].'.index') }}">{{ __("backend.menu.{$sub_value['title']}") }}</a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                        @else      
                            @if(in_array('read '.$value['name'], $permissions) || auth()->user()->super_admin)
                            <a class="{{ request()->is('backend/'.$value['active']) || request()->is('backend/'.$value['active'].'/*') ? ' active' : '' }}" href="{{ route('backend.'.$value['name'].'.index') }}">
                                <i class="{{ $value['icon'] }}"></i>
                                <span class="sidebar-mini-hide">{{ __("backend.menu.{$value['title']}") }}</span>                         
                            </a>    
                            @endif                
                        @endif                      
                    </li>
                @endforeach
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>
