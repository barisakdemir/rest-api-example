<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'site_url',
        'name',
        'lastname',
        'company_name',
        'email',
        'password',
        'token',
    ];

    public function companyPackages()
    {
        return $this->hasMany(CompanyPackage::class)->select(['id', 'company_id', 'package_id', 'created_at', 'end_at']);
    }
}
