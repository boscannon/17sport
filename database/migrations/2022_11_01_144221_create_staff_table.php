<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('no', 50)->unique()->comment('編號');
            $table->string('name', 50)->comment('名稱');
            $table->string('english_name', 50)->nullable()->comment('英文名稱');
            $table->string('identification', 10)->comment('身分證');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete()->comment('所屬部門id');
            $table->date('appointment_date')->nullable()->comment('到職日期');
            $table->date('resignation_date')->nullable()->comment('離職日期');
            $table->string('telephone', 10)->nullable()->comment('連絡電話');
            $table->string('cellphone', 10)->nullable()->comment('手機');
            $table->string('address', 200)->nullable()->comment('地址');
            $table->string('email', 150)->nullable()->comment('email');
            $table->string('line', 50)->nullable()->comment('line');
            $table->string('emergency_contact', 50)->nullable()->comment('緊急聯絡人');
            $table->string('emergency_contact_phone', 10)->nullable()->comment('緊急聯絡人電話');
            $table->string('remark', 200)->nullable()->comment('備註');
            $table->timestamps();
        });

        // 创建权限
        Permission::create(['name' => 'read staff', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create staff', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit staff', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete staff', 'guard_name' => 'admin']);        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
