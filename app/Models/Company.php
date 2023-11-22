<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $table = "companies";
    use HasFactory, SoftDeletes;


    public function documents()
    {
        return $this->hasMany(CompanyDocuments::class,'company_id','id');
    }

    public function history()
    {
        return $this->hasMany(CompanyStatusHistory::class,'company_id','id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'assigned_companies');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id', "id");
    }

}
