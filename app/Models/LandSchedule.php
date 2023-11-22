<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = ['valid_till' => 'date'];

    public function origin() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_id', 'id');
    }

    public function destination() : BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_id', 'id');
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function containerSize() : BelongsTo
    {
        return $this->belongsTo(ContainerSizes::class, 'container_size', 'value');
    }

    public function truckType() : BelongsTo
    {
        return $this->belongsTo(TruckType::class);
    }
}
