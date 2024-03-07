<?php

declare(strict_types=1);

namespace App\Payment;

use App\DTO\PayResultDTO;
use App\PaymentProcessor\PaypalPaymentProcessor;
use Exception;

class PaypalPayment implements PaymentInterface
{
    public function pay(float $price): PayResultDTO
    {
        $processor = new PaypalPaymentProcessor();

        try {
            $processor->pay((int) $price);

            return new PayResultDTO(message: 'Payment successful', isSuccess: true);
        } catch (Exception $e) {
            return new PayResultDTO(message: $e->getMessage(), isSuccess: false);
        }
    }
}