<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VehicleType extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'vehicleTypes';

    protected $fillable = [
        'number', 'cost_km', 'minimum',
    ];
}