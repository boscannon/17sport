<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'source',
        'date',
        'recipient_name',
        'recipient_phone',
        'recipient_cellphone',
        'purchaser_name',
        'purchaser_cellphone',
        'due_date',
        'remark',
    ];


    protected $casts = [
        'no' => 'string',
        'source' => 'string',
        'date' => 'datetime:Y-m-d H:i:s',
        'recipient_name' => 'string',
        'recipient_phone' => 'string',
        'recipient_cellphone' => 'string',
        'purchaser_name' => 'string',
        'purchaser_cellphone' => 'string',
        'due_date' => 'datetime:Y-m-d H:i:s',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];      
}
