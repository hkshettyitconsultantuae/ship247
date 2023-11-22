<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickRequestForms extends Model
{
    protected $table = "quick_request_forms";
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'company',
        'description',
        'phone',
        'company',
        'origin_name',
        'route_type',
        'destination_name',
    ];
}
