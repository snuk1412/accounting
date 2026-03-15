<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'business_name',
        'fullname',
        'building',
        'room_no',
        'floor',
        'village',
        'house_no',
        'moo',
        'soi',
        'junction',
        'road',
        'subdistrict',
        'district',
        'province',
        'postcode',
        'tax_id',
        'phone',
        'commercial_registration_no',
'commercial_registration_date'
    ];

}
