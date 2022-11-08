<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \App\Traits\ObserverTrait;

    use HasFactory;

    protected $fillable = [
        'barcode',
        'yahoo_id',
        'momo_id',
        'name',
        'specification',
        'resignation_date',
        'unit',
        'type',
        'size',
        'price',
        'stock',
        'remark',
    ];


    protected $casts = [
        'barcode' => 'string',
        'yahoo_id' => 'integer',
        'momo_id' => 'integer',
        'name' => 'string',
        'specification' => 'string',
        'resignation_date' => 'string',
        'unit' => 'string',
        'type' => 'string',
        'size' => 'string',
        'price' => 'integer',
        'stock' => 'integer',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];      

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'yahoo_id',
            'momo_id',
            'barcode',
            'name',
            'specification',
            'resignation_date',
            'unit',
            'type',
            'size',
            'price',
            'stock',
            'remark',
        ],    
    ];  
}
