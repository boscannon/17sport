<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 150)->unique()->comment('國際條碼');
            $table->string('yahoo_id', 150)->nullable()->unique()->comment('yahoo產品編號');
            $table->string('momo_id', 150)->nullable()->unique()->comment('momo產品編號');
            $table->string('momo_dt_code', 150)->nullable()->unique()->comment('momo 品號');
            $table->string('name', 150)->nullable()->comment('名稱');
            $table->string('specification', 150)->nullable()->comment('規格');
            $table->string('unit', 150)->nullable()->comment('單位');
            $table->string('type', 150)->nullable()->comment('型號');
            $table->string('size', 150)->nullable()->comment('尺寸');            
            $table->unsignedInteger('price')->default(0)->comment('售價');
            $table->Integer('stock')->default(0)->comment('庫存');
            $table->string('attribute', 255)->nullable()->comment('屬性');
            $table->text('remark')->nullable()->comment('備註');
            $table->timestamps();
        });
        
        // 创建权限
        Permission::create(['name' => 'read products', 'guard_name' => 'admin']);
        Permission::create(['name' => 'create products', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit products', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete products', 'guard_name' => 'admin']);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
