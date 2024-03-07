<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Exception\NotFoundException;
use App\Repository\ProductRepository;

class CalculatePriceService
{
    private CalculateTaxPriceService $calculateTaxPriceService;
    private CalculateDiscountPriceService $calculateDiscountPriceService;
    private ProductRepository $productRepository;

    public function __construct(CalculateTaxPriceService $calculateTaxPriceService, CalculateDiscountPriceService $calculateDiscountPriceService, ProductRepository $productRepository)
    {
        $this->calculateTaxPriceService = $calculateTaxPriceService;
        $this->calculateDiscountPriceService = $calculateDiscountPriceService;
        $this->productRepository = $productRepository;
    }

    public function calculate(int $productId, string $taxNumber, ?string $couponCode): float
    {
        /** @var Product $product */
        $product = $this->productRepository->find($productId);

        if ($product) {

            $productPrice = $product->getPrice();

            if ($couponCode) {
                $discountValue = $this->calculateDiscountPriceService->getDiscountValue($product->getPrice(), $couponCode);
                $productPrice = $productPrice - $discountValue;
            }

            $taxValue = $this->calculateTaxPriceService->calculate($productPrice, $taxNumber);

            return $productPrice + $taxValue;
        }

        throw new NotFoundException(['Not found product by id']);
    }
}