<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected function routeTypeLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->route_type === ROUTE_TYPE_SEA ? 'Sea' : 'Land',
        );
    }
}
