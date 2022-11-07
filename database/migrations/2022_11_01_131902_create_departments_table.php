<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('no', 50)->unique()->comment('部門編號');
            $table->string('name', 50)->comment('部門名稱');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('上層部門');
            $table->integer('level')->default(1)->comment('層級');
            $table->text('remark')->nullable()->comment('備註');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('departments')->nullOnDelete();
        });

        // 创建权限
        Permission::create(['name' => 'read departments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create departments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit departments', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete departments', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
