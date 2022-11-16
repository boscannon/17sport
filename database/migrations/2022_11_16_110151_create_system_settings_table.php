<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique()->comment('設定名稱');
            $table->string('value', 255)->comment('設定內容');
            $table->timestamps();
        });

        DB::table('system_settings')->insert(['key' => 'momo_password', 'value' => 'tmc100201']);

        // 创建权限
        Permission::create(['name' => 'read system_settings', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create system_settings', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit system_settings', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete system_settings', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
}
