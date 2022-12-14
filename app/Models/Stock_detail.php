<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_detail extends Model
{
    use HasFactory;
    use \App\Traits\HasDateTimeFormatter;

    protected $fillable = [
        'product_id',
        'order_id',
        'source',
        'name',
        'type',
        'size',
        'amount',
        'stock',
    ];


    protected $casts = [
        'product_id' => 'integer',
        'order_id' => 'integer',
        'source' => 'string',
        'name' => 'string',
        'type' => 'string',
        'size' => 'string',
        'amount' => 'string',
        'stock' => 'string',

        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];           

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
