<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('recipient_phone', 10)->nullable()->comment('收件人電話');
            $table->string('recipient_cellphone', 10)->nullable()->comment('收件人手機');
            $table->string('purchaser_name', 50)->nullable()->comment('購買人姓名');
            $table->string('purchaser_cellphone', 10)->nullable()->comment('購買人手機');
            $table->timestamp('due_date')->nullable()->comment('應出貨日');
            $table->text('remark')->nullable()->comment('備註'); 
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
        Schema::dropIfExists('orders');
    }
}
