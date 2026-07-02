<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
    'property_number',
    'type',
    'description',
    'status',

    // Specifications
    'brand',
    'model',
    'serial_number',
    'manufacturer',

    // Assignment
    'assigned_to',
    'department',
    'location',

    // Acquisition
    'acquisition_date',
    'acquisition_cost',
    'supplier',
    'warranty_expiry',
];

}

