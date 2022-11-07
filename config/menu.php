<?php

return [
    [ 'active' => 'basic/*', 'icon' => 'si si-notebook', 'title' => 'basic', 'child' =>
        [
            [ 'active' => 'basic/departments*', 'name' => 'departments', 'title' => 'departments', 'routeId' => 'department', 'permissions' => 'departments' ],
            [ 'active' => 'basic/jobs*', 'name' => 'jobs', 'title' => 'jobs', 'routeId' => 'job', 'permissions' => 'jobs' ],
            [ 'active' => 'basic/staff*', 'name' => 'staff', 'title' => 'staff', 'routeId' => 'staff', 'permissions' => 'staff' ],
            [ 'active' => 'basic/members*', 'name' => 'members', 'title' => 'members', 'routeId' => 'member', 'permissions' => 'members' ],
            [ 'active' => 'basic/suppliers*', 'name' => 'suppliers', 'title' => 'suppliers', 'routeId' => 'supplier', 'permissions' => 'suppliers' ],
        ]
    ],
    [ 'active' => 'users_setting/*', 'icon' => 'si si-users', 'title' => 'users_setting', 'child' =>
        [
            [ 'active' => 'users_setting/roles*', 'name' => 'roles', 'title' => 'roles', 'routeId' => 'role', 'permissions' => 'roles' ],
            [ 'active' => 'users_setting/users*', 'name' => 'users', 'title' => 'users', 'routeId' => 'user', 'permissions' => 'users' ],
        ]
    ],
];
