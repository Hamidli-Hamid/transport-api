<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\Services\Contracts\DistanceServiceInterface;
use GuzzleHttp\Client;

class GoogleDistanceService implements DistanceServiceInterface
{
    private Client $client;
    private string $apiKey;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getTotalDistance(array $addresses): float
    {
        $origin = urlencode($this->formatAddress($addresses[0]));
        $destination = urlencode($this->formatAddress(end($addresses)));

        $response = $this->client->get("https://maps.googleapis.com/maps/api/distancematrix/json", [
            'query' => [
                'origins' => $origin,
                'destinations' => $destination,
                'key' => $this->apiKey,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['status'] !== 'OK') {
            throw new \RuntimeException('Google Maps API error: ' . $data['status']);
        }

        return $data['rows'][0]['elements'][0]['distance']['value'] / 1000; // Convert meters to kilometers
    }

    private function formatAddress(AddressDTO $address): string
    {
        return "{$address->city}, {$address->zip}, {$address->country}";
    }
}
