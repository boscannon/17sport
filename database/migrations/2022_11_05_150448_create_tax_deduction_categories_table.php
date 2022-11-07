<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxDeductionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_deduction_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('名稱');
            $table->timestamps();
        });

        DB::table('tax_deduction_categories')->insert(['name' => '應稅內含']);
        DB::table('tax_deduction_categories')->insert(['name' => '應稅外加']);
        DB::table('tax_deduction_categories')->insert(['name' => '不計稅']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_deduction_categories');
    }
}
