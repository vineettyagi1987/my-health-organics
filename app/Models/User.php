<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
     const ROLE_ADMIN = 'admin';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_DISTRIBUTOR = 'distributor';
    const ROLE_CUSTOMER = 'customer';
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'my_referral_code',
        'referral_code',
        'password',
        'role',
        'department',
        'company_title',
        'region_area',
        'commission_rate',
          'emp_id',
         'dist_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
{
    return $this->role === self::ROLE_ADMIN;
}

public function isEmployee()
{
    return $this->role === self::ROLE_EMPLOYEE;
}

public function isDistributor()
{
    return $this->role === self::ROLE_DISTRIBUTOR;
}

public function isCustomer()
{
    return $this->role === self::ROLE_CUSTOMER;
}
protected static function booted()
{
    static::creating(function ($user) {

        // Employee ID
        if ($user->role === self::ROLE_EMPLOYEE && empty($user->emp_id)) {
            $nextId = self::where('role', self::ROLE_EMPLOYEE)->max('id') + 1;
            $user->emp_id = 'EMP-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }

        // Distributor ID
        if ($user->role === self::ROLE_DISTRIBUTOR && empty($user->dist_id)) {
            $nextId = self::where('role', self::ROLE_DISTRIBUTOR)->max('id') + 1;
            $user->dist_id = 'DIST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }
    });
}


}


