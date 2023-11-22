<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class HotDeal extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'etd' => 'date',
        'eta' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected function routeTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->route_type === ROUTE_TYPE_SEA ? 'Sea' : 'Land',
        );
    }

    protected function routeFullname(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->origin->fullname} -> {$this->destination->fullname}",
        );
    }

    public function scopeValid(Builder $query): void
    {
        $today = Carbon::now();
        $query->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

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
}
