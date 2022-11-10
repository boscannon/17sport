<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \App\Traits\ObserverTrait;

    use HasFactory;

    protected $fillable = [        
        'yahoo_id',
        'momo_id',
        'momo_dt_code',
        'barcode',
        'name',
        'specification',
        'unit',
        'type',
        'size',
        'price',
        'stock',
        'attribute',
        'remark',

        'resignation_date',
    ];


    protected $casts = [        
        'yahoo_id' => 'string',
        'momo_id' => 'string',
        'momo_dt_code' => 'string',
        'barcode' => 'string',
        'name' => 'string',
        'specification' => 'string',        
        'unit' => 'string',
        'type' => 'string',
        'size' => 'string',
        'price' => 'integer',
        'stock' => 'integer',
        'attribute' => 'string',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',

        'resignation_date' => 'string',
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
            'unit',
            'type',
            'size',            
            'price',
            'stock',
            'attribute',
            'remark',

            'resignation_date',
        ],    
    ];  

    public function stockDetail(){
        return $this->hasMany(Stock_detail::class);
    }
}
