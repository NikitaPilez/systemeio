<?php

declare(strict_types=1);

namespace App\Service;

class CalculateTaxPriceService
{
    public function calculate(float $price, string $taxNumber): float
    {
        $taxPercent = $this->getTaxPercentByCode($taxNumber);

        return $price * ($taxPercent / 100);
    }

    public function getTaxPercentByCode(string $taxNumber): int
    {
        $countryCode = substr($taxNumber, 0, 2);

        return match($countryCode) {
            'DE' => 19,
            'IT' => 22,
            'FR' => 20,
            'GR' => 24,
            default => 0
        };
    }
}