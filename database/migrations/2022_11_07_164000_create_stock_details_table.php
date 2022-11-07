<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('no', 50)->comment('編號');
            $table->string('barcode', 50)->comment('條碼');
            $table->string('name', 50)->comment('名稱');
            $table->string('type', 50)->nullable()->comment('型號');
            $table->string('size', 50)->nullable()->comment('尺寸');
            $table->unsignedInteger('amount')->default(0)->comment('售價');
            $table->unsignedInteger('stock')->default(0)->comment('售價');
            $table->timestamps();
        });
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
