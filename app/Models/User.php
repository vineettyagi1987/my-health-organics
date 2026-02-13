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

}
