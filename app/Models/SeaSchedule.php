<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeaSchedule extends Model
{
    use HasFactory, SoftDeletes;

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

    public function details() : HasMany
    {
        return $this->hasMany(SeaScheduleDetail::class);
    }

    public function containerSize() : BelongsTo
    {
        return $this->belongsTo(ContainerSizes::class, 'container_size', 'value');
    }

    public function pickupAndDeliveryScheduleOrigin() : HasMany
    {
        return $this->hasMany(PickAndDeliverySchedule::class, 'destination_id', 'origin_id');
    }

    public function pickupAndDeliveryScheduleDestination() : HasMany
    {
        return $this->hasMany(PickAndDeliverySchedule::class, 'origin_id', 'destination_id');
    }
}
