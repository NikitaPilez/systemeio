<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Coupon;
use App\Enum\DiscountType;
use App\Repository\CouponRepository;

class CalculateDiscountPriceService
{
    private CouponRepository $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function getDiscountValue(float $price, string $code): float
    {
        /** @var Coupon $coupon */
        $coupon = $this->couponRepository->findOneByCode($code);

        if ($coupon) {
            return $coupon->getType() === DiscountType::FIX->value ? $coupon->getValue() : $price / $coupon->getValue();
        }

        return 0.0;
    }
}