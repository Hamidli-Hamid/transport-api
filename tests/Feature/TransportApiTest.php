<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransportApiTest extends TestCase
{
    public function testCalculatePriceSuccessfully()
    {
        $response = $this->withHeaders([
            'x-api-key' => 'your_secure_api_key',
        ])->postJson('/api/calculate-price', [
            'addresses' => [
                ['country' => 'DE', 'zip' => '10115', 'city' => 'Berlin'],
                ['country' => 'DE', 'zip' => '20095', 'city' => 'Hamburg'],
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['vehicle_type', 'price']
        ]);
    }

    public function testUnauthorizedRequest()
    {
        $response = $this->postJson('/api/calculate-price', [
            'addresses' => [
                ['country' => 'DE', 'zip' => '10115', 'city' => 'Berlin'],
                ['country' => 'DE', 'zip' => '20095', 'city' => 'Hamburg'],
            ]
        ]);

        $response->assertStatus(401); // Unauthorized
        $response->assertJson(['message' => 'Unauthorized']);
    }

    public function testInvalidAddress()
    {
        $response = $this->withHeaders([
            'x-api-key' => 'your_secure_api_key',
        ])->postJson('/api/calculate-price', [
            'addresses' => [
                ['country' => 'DE', 'zip' => '99999', 'city' => 'NonexistentCity'],
                ['country' => 'DE', 'zip' => '20095', 'city' => 'Hamburg'],
            ]
        ]);

        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['addresses']);
    }
}