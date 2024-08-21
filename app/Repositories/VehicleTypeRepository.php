<?php

namespace App\Repositories;

use MongoDB\Client;
use MongoDB\Collection;

class VehicleTypeRepository
{
    private Collection $collection;

    public function __construct(Client $client)
    {
        $this->collection = $client->interview->vehicleTypes;
    }

    public function getAll(): array
    {
        return $this->collection->find()->toArray();
    }
}
