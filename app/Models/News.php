<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'published_date' => 'datetime',
    ];

    public function scopePublished(Builder $query): void
    {
        $today = Carbon::now();
        $query->whereDate('published_date', '<=', $today);
    }
}
