<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('no', 50)->unique()->comment('編號');
            $table->string('name', 50)->comment('名稱');
            $table->string('uniform_numbers', 50)->nullable()->comment('統編');
            $table->string('principal', 50)->nullable()->comment('負責人');
            $table->string('address', 100)->nullable()->comment('地址');
            $table->string('contact_person', 50)->nullable()->comment('聯絡人');
            $table->string('telephone', 50)->nullable()->comment('聯絡人電話');
            $table->string('email')->nullable()->comment('email');
            $table->string('business_items', 50)->nullable()->comment('營業項目');
            $table->integer('tax')->nullable()->comment('稅金');
            $table->foreignId('billing_method_id')->nullable()->constrained()->nullOnDelete()->comment('立帳方式id');
            $table->foreignId('tax_deduction_category_id')->nullable()->constrained()->nullOnDelete()->comment('扣稅類別id');
            $table->string('invoice_address', 50)->nullable()->comment('發票地址');
            $table->string('invoice_issuing_company', 50)->nullable()->comment('發票開立公司別');
            $table->integer('checkout_date')->nullable()->comment('結帳日');
            $table->text('remark')->nullable()->comment('備註');
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete()->comment('收款方式id');
            $table->integer('days')->nullable()->comment('天數');
            $table->text('other_instructions')->nullable()->comment('其他說明');
            $table->string('bank_account', 50)->nullable()->comment('銀行帳戶');
            $table->tinyInteger('status')->default(1)->comment('狀態');
            $table->date('retirement_date')->nullable()->comment('停用日期');
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
        Schema::dropIfExists('suppliers');
    }
}
