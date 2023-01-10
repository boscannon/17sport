<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System_setting extends Model
{
    use \App\Traits\ObserverTrait;
    use \App\Traits\HasDateTimeFormatter;
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'key' => 'string',
        'value' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'key',
            'value',
        ],
        // //關聯轉換
        // 'translation' => [
        //     'parent_id' => [               //關聯欄位
        //         'relation' => 'parent',   //關聯名稱
        //         'name' => 'name',       //顯示欄位
        //     ]
        // ],
        //多對多
        // 'many' => [
        //     'roles' => 'name'
        // ]
    ];
}
