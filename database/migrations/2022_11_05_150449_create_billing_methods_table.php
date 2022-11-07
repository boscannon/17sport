<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('名稱');
            $table->timestamps();
        });

        DB::table('billing_methods')->insert(['name' => '單張立帳']);
        DB::table('billing_methods')->insert(['name' => '開出發票才立帳']);
        DB::table('billing_methods')->insert(['name' => '不立帳']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_methods');
    }
}
