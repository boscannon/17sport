<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->string('no', 50)->comment('編號');
            $table->string('source', 50)->comment('來源');
            $table->timestamp('date')->nullable()->comment('date');
            $table->string('recipient_name', 50)->nullable()->comment('收件人姓名');
            $table->string('recipient_phone', 20)->nullable()->comment('收件人電話');
            $table->string('recipient_cellphone', 20)->nullable()->comment('收件人手機');
            $table->string('purchaser_name', 50)->nullable()->comment('購買人姓名');
            $table->string('purchaser_cellphone', 20)->nullable()->comment('購買人手機');
            $table->timestamp('due_date')->nullable()->comment('應出貨日');
            $table->text('remark')->nullable()->comment('備註');
            $table->text('json')->nullable()->comment('全部資料');
            $table->timestamps();
            $table->unique('no', 'source');
        });
        
        // 创建权限
        Permission::create(['name' => 'read orders', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create orders', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit orders', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete orders', 'guard_name' => 'admin']);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
