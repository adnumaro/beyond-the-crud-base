<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Models;

class ExchangeRateResult
{
    public function __construct(
        private readonly ExchangeRate $baseFrom,
        private readonly ExchangeRate $baseTo,
        private readonly float $amount,
    ) {
    }

    public function getBaseFrom(): ExchangeRate
    {
        return $this->baseFrom;
    }

    public function getBaseTo(): ExchangeRate
    {
        return $this->baseTo;
    }

    public function getRate(): float
    {
        return $this->amount * $this->baseFrom->getRate();
    }
}
