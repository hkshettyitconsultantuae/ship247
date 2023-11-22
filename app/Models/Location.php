<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['fullname', 'shortname'];

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->port}, {$this->country->name} [{$this->code}]",
        );
    }

    protected function shortname(): Attribute
    {
        return Attribute::make(
            get: fn() => substr($this->city ?? $this->port, 0, 10) . ", {$this->country->code}",
        );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
