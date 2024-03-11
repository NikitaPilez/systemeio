<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CalculatePriceDTO;
use App\DTO\PayDTO;
use App\Request\CalculatePriceRequest;
use App\Request\PayRequest;
use App\Service\CalculatePriceService;
use App\Service\PayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate', methods: ['POST'])]
    public function calculate(
        CalculatePriceRequest $request,
        CalculatePriceService $calculatePriceService): JsonResponse
    {
        $calculatePriceDTO = CalculatePriceDTO::fromRequest($request);

        return $this->json([
            'price' => $calculatePriceService->calculate($calculatePriceDTO->productId, $calculatePriceDTO->taxNumber, $calculatePriceDTO->couponCode),
        ]);
    }

    #[Route('/pay', name: 'pay', methods: ['POST'])]
    public function pay(
        PayRequest $request,
        PayService $payService): JsonResponse
    {
        $payDTO = PayDTO::fromRequest($request);

        $payResultDto = $payService->pay($payDTO->productId, $payDTO->taxNumber, $payDTO->paymentProcessor, $payDTO->couponCode);

        return $this->json([
            'success' => $payResultDto->isSuccess,
            'message' => $payResultDto->message,
        ]);
    }
}
