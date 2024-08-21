<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\Repositories\CityRepository;
use App\Repositories\VehicleTypeRepository;
use App\Services\Contracts\DistanceServiceInterface;

class TransportService
{
    private CityRepository $cityRepository;
    private VehicleTypeRepository $vehicleTypeRepository;
    private DistanceServiceInterface $distanceService;

    public function __construct(
        CityRepository $cityRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        DistanceServiceInterface $distanceService
    ) {
        $this->cityRepository = $cityRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->distanceService = $distanceService;
    }

    public function calculatePrice(array $addresses): array
    {
        $distance = $this->distanceService->getTotalDistance($addresses);

        $vehicleTypes = $this->vehicleTypeRepository->getAll();
        $prices = [];

        foreach ($vehicleTypes as $vehicleType) {
            $cost = $distance * $vehicleType['cost_km'];
            $price = max($cost, $vehicleType['minimum']);

            $prices[] = [
                'vehicle_type' => $vehicleType['number'],
                'price' => round($price, 2)
            ];
        }

        return $prices;
    }

    public function validateAddresses(array $addresses): void
    {
        foreach ($addresses as $address) {
            if (!$this->cityRepository->exists($address->country, $address->zip, $address->city)) {
                throw new \InvalidArgumentException('Invalid address: ' . $address->city);
            }
        }
    }

    
}
