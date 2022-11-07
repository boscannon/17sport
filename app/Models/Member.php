<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;

class Member extends Authenticatable
{
    use \App\Traits\ObserverTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'sex',
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
        'name' => 'string',
        'sex' => 'string',
        'status' => 'integer',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
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
            'sex',
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

    public function sendPasswordResetNotification($token){
        $this->notify(new ResetPasswordNotification($token));
    }
}
