<?php

namespace App\DTO;

class AddressDTO
{
    public string $country;
    public string $zip;
    public string $city;

    public function __construct(string $country, string $zip, string $city)
    {
        $this->country = $country;
        $this->zip = $zip;
        $this->city = $city;
    }

    public static function fromArray(array $data): AddressDTO
    {
        return new self($data['country'], $data['zip'], $data['city']);
    }
}