<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\PayResultDTO;
use App\Payment\PaymentProcessorFactory;
use Exception;

class PayService
{
    private CalculatePriceService $calculatePriceService;
    private PaymentProcessorFactory $paymentProcessor;

    public function __construct(CalculatePriceService $calculatePriceService, PaymentProcessorFactory $paymentProcessor)
    {
        $this->calculatePriceService = $calculatePriceService;
        $this->paymentProcessor = $paymentProcessor;
    }

    public function pay(int $productId, string $taxNumber, string $paymentProcessor, ?string $couponCode): PayResultDTO
    {
        $price = $this->calculatePriceService->calculate($productId, $taxNumber, $couponCode);

        try {
            $processor = $this->paymentProcessor->createProcessor($paymentProcessor);
            $payResultDTO = $processor->pay($price);

            return new PayResultDTO(message: $payResultDTO->message, isSuccess: $payResultDTO->isSuccess);
        } catch (Exception $e) {
            return new PayResultDTO(message: $e->getMessage(), isSuccess: false);
        }
    }
}