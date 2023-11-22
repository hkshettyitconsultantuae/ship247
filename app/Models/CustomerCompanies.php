<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCompanies extends Model
{

    public function company_details()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    
    public function customer_details()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }

    protected $fillable  = [
        'customer_id',
        'company_id',
    ];

    protected $table = "assigned_companies";
    use HasFactory;
}
