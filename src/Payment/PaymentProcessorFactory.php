<?php

declare(strict_types=1);

namespace App\Payment;

use Exception;

class PaymentProcessorFactory
{
    /**
     * @throws \Exception
     */
    public function createProcessor($paymentType): PaymentInterface
    {
        return match ($paymentType) {
            'paypal' => new PaypalPayment(),
            'stripe' => new StripePayment(),
            default => throw new Exception('Not found pay method'),
        };
    }
}