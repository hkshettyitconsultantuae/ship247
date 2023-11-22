<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    protected $table = "payments";
    use HasFactory, SoftDeletes;


    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
