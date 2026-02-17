<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'equipment_id',
        'reservation_id',
        'rating',
        'comment',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}