<?php

declare(strict_types=1);

namespace App\DTO;

class PayResultDTO
{
    public function __construct(public string $message, public bool $isSuccess)
    {
    }
}