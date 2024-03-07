<?php

declare(strict_types=1);

namespace App\DTO;

use App\Request\CalculatePriceRequest;

class CalculatePriceDTO
{
    public function __construct(public int $productId, public string $taxNumber, public ?string $couponCode)
    {
    }

    public static function fromRequest(CalculatePriceRequest $request): CalculatePriceDTO
    {
        return new CalculatePriceDTO($request->productId, $request->taxNumber, $request->couponCode);
    }
}