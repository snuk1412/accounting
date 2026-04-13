<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tax_id',
        'business_type',
        'industry_type',
        'product_type',
        'employee_count',
        'address',
        'phone',
        'email',
        'logo',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
