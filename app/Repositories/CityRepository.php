<?php

namespace App\Repositories;

use MongoDB\Client;
use MongoDB\Collection;

class CityRepository
{
    private Collection $collection;

    public function __construct(Client $client)
    {
        $this->collection = $client->interview->cities;
    }

    public function exists(string $country, string $zip, string $city): bool
    {
        return $this->collection->findOne([
            'country' => $country,
            'zipCode' => $zip,
            'name' => $city,
        ]) !== null;
    }
}