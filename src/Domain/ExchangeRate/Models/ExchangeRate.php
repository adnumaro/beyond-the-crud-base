<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Models;

class ExchangeRate
{
    public function __construct(private readonly string $base, private readonly float $rate)
    {
    }

    public function getBase(): string
    {
        return $this->base;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
