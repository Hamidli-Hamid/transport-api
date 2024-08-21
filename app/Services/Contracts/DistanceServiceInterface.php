<?php

namespace App\Services\Contracts;

use App\DTO\AddressDTO;

interface DistanceServiceInterface
{
    public function getTotalDistance(array $addresses): float;
}