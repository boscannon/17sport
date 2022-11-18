<div class="content-side content-side-full content-side-user px-10 align-parent">
    <!-- Visible only in mini mode -->
    <div class="sidebar-mini-visible-b align-v animated fadeIn">
        <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
    </div>
    <!-- END Visible only in mini mode -->

    <!-- Visible only in normal mode -->
    <div class="sidebar-mini-hidden-b text-center">
        <div class="avatar-wrapper">
            <img class="profile-pic" src="{{ Auth::user()->avatar ?? '' }}" />
            <div class="upload-button">
                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
            </div>
            <input class="file-upload" type="file" accept="image/*"/>
        </div>
        <ul class="list-inline mt-10">
            <li class="list-inline-item">
                <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="javascript:void(0)">{{ Auth::user()->name }}</a>
            </li>
            <li class="list-inline-item">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                    <i class="si si-drop"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a class="link-effect text-dual-primary-dark" href="javascript:void(0)" onclick="$('#form').submit()">
                    <i class="si si-logout"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- END Visible only in normal mode -->
</div>