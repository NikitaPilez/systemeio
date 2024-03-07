<?php

declare(strict_types=1);

namespace App\Payment;

use App\DTO\PayResultDTO;

interface PaymentInterface
{
    public function pay(float $price): PayResultDTO;
}