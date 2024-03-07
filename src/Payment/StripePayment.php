<?php

declare(strict_types=1);

namespace App\Payment;

use App\DTO\PayResultDTO;
use App\PaymentProcessor\StripePaymentProcessor;

class StripePayment implements PaymentInterface
{
    public function pay(float $price): PayResultDTO
    {
        $processor = new StripePaymentProcessor();
        $paymentResult = $processor->processPayment($price);

        return new PayResultDTO(message: $paymentResult ? 'Payment successful' : 'Payment failed', isSuccess: $paymentResult);
    }
}