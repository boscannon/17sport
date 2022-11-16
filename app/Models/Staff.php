<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use \App\Traits\ObserverTrait;  
    use \App\Traits\HasDateTimeFormatter;
    use HasFactory;

    protected $fillable = [
        'no',
        'name',
        'identification',
        'department_id',
        'appointment_date',
        'resignation_date',
        'telephone',
        'cellphone',
        'address',
        'email',
        'emergency_contact',
        'emergency_contact_phone',
        'remark',
    ];


    protected $casts = [
        'no' => 'string',
        'name' => 'string',
        'identification' => 'string',
        'department_id' => 'integer',
        'appointment_date' => 'datetime:Y-m-d',
        'resignation_date' => 'datetime:Y-m-d',
        'telephone' => 'string',
        'cellphone' => 'string',
        'address' => 'string',
        'email' => 'string',
        'emergency_contact' => 'string',
        'emergency_contact_phone' => 'string',
        'remark' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];      

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'no',
            'name',
            'identification',
            'department_id',
            'appointment_date',
            'resignation_date',
            'telephone',
            'cellphone',
            'address',
            'email',
            'emergency_contact',
            'emergency_contact_phone',
            'remark',         
        ],
        // //關聯轉換
        'translation' => [
            'department_id' => [            
                'relation' => 'department',
                'name' => 'name',    
            ],
            'job_id' => [            
                'relation' => 'job',
                'name' => 'name',    
            ]            
        ],
        //多對多
        // 'many' => [
        //     'roles' => 'name'
        // ]         
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }    

    public function job(){
        return $this->belongsTo(Job::class);
    }    
}
