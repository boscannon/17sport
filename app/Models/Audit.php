<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    use \App\Traits\HasDateTimeFormatter;

    protected $fillable = [
        'user_id',
        'event',
        'table',
        'table_id',
        'old_values',
        'new_values',
        'auditing',
        'url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'event' => 'string',
        'table' => 'string',
        'table_id' => 'integer',
        'old_values' => 'array',
        'new_values' => 'array',
        'auditing' => 'array',
        'url' => 'string',
        'ip_address' => 'string',
        'user_agent' => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
