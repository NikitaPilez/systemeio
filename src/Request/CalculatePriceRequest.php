<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CalculatePriceRequest extends AbstractJsonRequest
{
    #[NotBlank(message: 'Product id is required field')]
    #[Type('integer')]
    public int $productId;

    #[NotBlank(message: 'Tax number is required field')]
    #[Type('string')]
    public string $taxNumber;

    #[Type('string')]
    public ?string $couponCode = null;
}