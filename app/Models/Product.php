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
        'momo_dt_code',
        'name',
        'specification',
        'resignation_date',
        'unit',
        'type',
        'size',
        'price',
        'stock',
        'attribute',
        'remark',
    ];


    protected $casts = [
        'barcode' => 'string',
        'yahoo_id' => 'string',
        'momo_id' => 'string',
        'momo_dt_code' => 'string',
        'name' => 'string',
        'specification' => 'string',
        'resignation_date' => 'string',
        'unit' => 'string',
        'type' => 'string',
        'size' => 'string',
        'price' => 'integer',
        'stock' => 'integer',
        'attribute' => 'string',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];      

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'yahoo_id',
            'momo_id',
            'momo_dt_code',
            'barcode',
            'name',
            'specification',
            'resignation_date',
            'unit',
            'type',
            'size',            
            'price',
            'stock',
            'attribute',
            'remark',
        ],    
    ];  

    public function stockDetail(){
        return $this->hasMany(Stock_detail::class);
    }
}
