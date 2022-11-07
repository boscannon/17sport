<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use \App\Traits\ObserverTrait;
    use HasFactory;

    protected $fillable = [
        'no',
        'name',
        'remark',
    ];

    protected $casts = [
        'no' => 'string',
        'name' => 'string',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'no',
            'name',
            'remark',
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
