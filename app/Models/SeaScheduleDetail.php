<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeaScheduleDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['eta', 'etd', 'valid_till', 'tt', 'ft'];

    protected $casts = ['eta' => 'date', 'etd' => 'date', 'valid_till' => 'date'];

    public function schedule() : BelongsTo {
        return $this->belongsTo(SeaSchedule::class);
    }
}
