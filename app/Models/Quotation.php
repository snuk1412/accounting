<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';

    protected $fillable = [
        'quotation_no',
        'customer_id',
        'quote_date',
        'valid_until',
        'total',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
        'quote_date' => 'date',
        'valid_until' => 'date',
    ];

    // relation
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
