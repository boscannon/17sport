<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sex', 10)->default(1)->comment('性別');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->tinyInteger('status')->default(1)->comment('狀態');
            $table->timestamps();
        });

        // 創建權限
        Permission::create(['name' => 'read members', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create members', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit members', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete members', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
