<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('no', 50)->unique()->comment('職位編號');
            $table->string('name', 50)->comment('職位名稱');
            $table->text('remark')->nullable()->comment('備註');
            $table->timestamps();
        });

        // 创建权限
        Permission::create(['name' => 'read jobs', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create jobs', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit jobs', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete jobs', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
