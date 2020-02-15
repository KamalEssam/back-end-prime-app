<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'google_id',
        'is_active',
        'role_id',
        'facebook_id',
        'last_notification_click',
        'is_notification',
        'pin'
    ];

    protected const ADMIN = 1;
    protected const SALE = 2;
    protected const USER = 3;

    protected $hidden = [
        'created_at', 'updated_at', 'password', 'remember_token'
    ];

    protected $casts = [
        'id' => 'integer',
        'gender' => 'integer',
        'role_id' => 'integer',
        'is_facebook' => 'integer',
        'is_active' => 'integer',
    ];

    public function getEmailAttribute($value)
    {
        return $value ?? $value = ' ';
    }

    public function getAddressAttribute($value)
    {
        return $value ?? $value = trans('lang.not_set');
    }

    public function setPasswordAttribute($value)
    {
        if ($value != null) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function scopeAdmin($query)
    {
        return $query->where('role_id', self::ADMIN);
    }

    public function scopeSale($query)
    {
        return $query->where('role_id', self::SALE);
    }

    public function scopeUser($query)
    {
        return $query->where('role_id', self::USER);
    }

}
