<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAddonDetails extends Model
{
    use HasFactory;

    public function details()
    {
        return $this->belongsTo(BookingAddon::class,'addon_id','id');
    }
}
