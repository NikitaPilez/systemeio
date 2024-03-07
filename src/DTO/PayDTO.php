<?php

declare(strict_types=1);

namespace App\DTO;

use App\Request\PayRequest;

class PayDTO
{
    public function __construct(public int $productId, public string $taxNumber, public string $paymentProcessor, public ?string $couponCode)
    {
    }

    public static function fromRequest(PayRequest $request): PayDTO
    {
        return new PayDTO($request->productId, $request->taxNumber, $request->paymentProcessor, $request->couponCode);
    }
}