<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class PickAndDeliverySchedule extends Model
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

    public function scopeFilterByOriginAndContainerSize(Builder $query, $origin_id, $container_size, $valid_till): void
    {
        $query->where('origin_id', $origin_id)
            ->where('container_size', $container_size)
            ->whereDate('valid_till', '>=', $valid_till);
    }

    public function scopeFilterByDestinationAndContainerSize(Builder $query, $destination_id, $container_size, $valid_till): void
    {
        $query->where('destination_id', $destination_id)
            ->where('container_size', $container_size)
            ->whereDate('valid_till', '>=', $valid_till);
    }
}
