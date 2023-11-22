<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyStatusHistory extends Model
{
    protected $table = "company_status_history";
    use HasFactory, SoftDeletes;
}
