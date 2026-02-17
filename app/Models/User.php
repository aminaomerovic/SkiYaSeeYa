<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'provider_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProvider()
    {
        return $this->role === 'provider';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}