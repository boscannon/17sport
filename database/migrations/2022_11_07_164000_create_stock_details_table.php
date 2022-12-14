<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete()->comment('產品id');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete()->comment('訂單id');
            $table->string('source', 50)->comment('來源');
            $table->string('name', 255)->comment('名稱');
            $table->string('type', 50)->nullable()->comment('型號');
            $table->string('size', 50)->nullable()->comment('尺寸');
            $table->Integer('amount')->default(0)->comment('數量');
            $table->Integer('stock')->default(0)->comment('庫存');
            $table->timestamps();
        });
        
        // 创建权限
        Permission::create(['name' => 'read stock_details', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create stock_details', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit stock_details', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete stock_details', 'guard_name' => 'admin']);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_details');
    }
}
