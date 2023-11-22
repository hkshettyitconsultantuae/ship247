<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDocuments extends Model
{
    protected $table = "company_documents";
    use HasFactory, SoftDeletes;
}
