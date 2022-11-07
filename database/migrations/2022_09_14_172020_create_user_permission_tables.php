<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserPermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 重置角色和权限缓存
        app()['cache']->forget('spatie.permission.cache');

        // 创建权限
        Permission::create(['name' => 'read users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'admin']);

        Permission::create(['name' => 'read roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete roles', 'guard_name' => 'admin']);        


        // 创建角色
        // $role = Role::create(['name' => 'admin', 'guard_name' => 'admin']);

        // 創建使用者並分配角色
        $user = User::create([ 'name' => 'admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('123qweasd') ]);
        // $user->assignRole('admin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 刪除使用者並刪除角色
        $user = User::where([ 'name' => 'admin', 'email' => 'admin@gmail.com'])->first();
        // $user->removeRole('admin');
        $user->delete();

        // 刪除角色
        // $role = Role::where(['name' => 'admin', 'guard_name' => 'admin'])->first();
        // $role->delete();

        // 刪除權限
        Permission::where(['name' => 'read users', 'guard_name' => 'admin'])->delete();
        Permission::where(['name' => 'create users', 'guard_name' => 'admin'])->delete();
        Permission::where(['name' => 'edit users', 'guard_name' => 'admin'])->delete();
        Permission::where(['name' => 'delete users', 'guard_name' => 'admin'])->delete();

    }

}
