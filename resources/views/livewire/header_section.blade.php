<div class="content-header-section">
    <!-- User Dropdown -->
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user d-sm-none"></i>
            <span class="d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
            <i class="fa fa-angle-down ml-5"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
            <a class="dropdown-item" href="{{ route('backend.edit_password.index') }}">
                <i class="si si-users mr-5"></i> {{ __('edit_password') }}
            </a>
            <a class="dropdown-item" href="javascript:void(0)" onclick="$('#form').submit()">
                <i class="si si-logout mr-5"></i> {{ __('sign_out') }}
            </a>
        </div>        
    </div>
    <!-- END User Dropdown -->

    <!-- Notifications -->
    <!-- END Notifications -->

    <!-- Toggle Side Overlay -->
    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
    <!-- END Toggle Side Overlay -->
</div>
