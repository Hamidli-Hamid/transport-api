<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePriceRequest;
use App\Services\TransportService;
use App\DTO\AddressDTO;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    private TransportService $transportService;

    public function __construct(TransportService $transportService)
    {
        $this->transportService = $transportService;
    }

    public function calculatePrice(Request $request)
    {
        $addresses = array_map(
            fn($data) => AddressDTO::fromArray($data),
            $request->input('addresses')
        );

        $this->transportService->validateAddresses($addresses);

        $prices = $this->transportService->calculatePrice($addresses);

        return response()->json($prices);
    }

  
}
