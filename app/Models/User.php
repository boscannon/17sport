<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use \App\Traits\ObserverTrait;
    use \App\Traits\HasDateTimeFormatter;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'status',
        'staff_id',
        'retirement_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
        'avatar' => 'string',
        'staff_id' => 'integer',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'retirement_date' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static $audit = [
        //要紀錄欄位
        'only' => [
            'name',
            'email',
            'status',           
            'staff_id',           
            'retirement_date'
        ],
        // //關聯轉換
        'translation' => [
            'staff_id' => [               //關聯欄位
                'relation' => 'staff',   //關聯名稱
                'name' => 'name',       //顯示欄位
            ]
        ],
        //多對多
        // 'many' => [
        //     'roles' => 'name'
        // ]         
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function getSuperAdminAttribute()
    {
        return true;
        // return in_array($this->email, explode(',', env('SUPER_ADMIN')));
    }
}
