<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use \App\Traits\ObserverTrait;
    use HasFactory;

    protected $fillable = [
        'no',
        'name',
        'uniform_numbers',
        'principal',
        'address',
        'contact_person',
        'telephone',
        'email',
        'business_items',
        'tax',
        'billing_method_id',
        'tax_deduction_category_id',
        'invoice_address',
        'invoice_issuing_company',
        'checkout_date',
        'remark',
        'payment_method_id',
        'days',
        'other_instructions',
        'bank_account',
        'status',
        'retirement_date',
    ];

    protected $casts = [
        'no' => 'string',
        'name' => 'string',
        'uniform_numbers' => 'string',
        'principal' => 'string',
        'address' => 'string',
        'contact_person' => 'string',
        'telephone' => 'string',
        'email' => 'string',
        'business_items' => 'string',
        'tax' => 'integer',
        'billing_method_id' => 'integer',
        'tax_deduction_category_id' => 'integer',
        'invoice_address' => 'string',
        'invoice_issuing_company' => 'string',
        'checkout_date' => 'integer',
        'remark' => 'string',
        'payment_method_id' => 'integer',
        'days' => 'integer',
        'other_instructions' => 'string',
        'bank_account' => 'string',
        'status' => 'integer',
        'retirement_date' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'no',
            'name',
            'uniform_numbers',
            'principal',
            'address',
            'contact_person',
            'telephone',
            'email',
            'business_items',
            'tax',
            'billing_method_id',
            'tax_deduction_category_id',
            'invoice_address',
            'invoice_issuing_company',
            'checkout_date',
            'remark',
            'payment_method_id',
            'days',
            'other_instructions',
            'bank_account',
            'status',
            'retirement_date',
        ],
        // //關聯轉換
        'translation' => [
            'billing_method_id' => [               //關聯欄位
                'relation' => 'billingMethod',   //關聯名稱
                'name' => 'name',       //顯示欄位
            ],
            'tax_deduction_category_id' => [               //關聯欄位
                'relation' => 'taxDeductionCategory',   //關聯名稱
                'name' => 'name',       //顯示欄位
            ],
            'payment_method_id' => [               //關聯欄位
                'relation' => 'paymentMethod',   //關聯名稱
                'name' => 'name',       //顯示欄位
            ]
        ],
        //多對多
        // 'many' => [
        //     'roles' => 'name'
        // ]
    ];

    public function billingMethod(){
        return $this->belongsTo(BillingMethod::class, 'billing_method_id');
    }

    public function taxDeductionCategory(){
        return $this->belongsTo(TaxDeductionCategory::class, 'tax_deduction_category_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
