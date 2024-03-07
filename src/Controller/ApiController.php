<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CalculatePriceDTO;
use App\Request\CalculatePriceRequest;
use App\Service\CalculatePriceService;
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
            'price' => $calculatePriceService->calculate($calculatePriceDTO),
        ]);
    }
}
