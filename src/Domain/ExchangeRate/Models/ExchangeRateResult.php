<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Models;

class ExchangeRateResult
{
    public function __construct(
        private readonly ExchangeRate $baseFromCurrency,
        private readonly ExchangeRate $baseToCurrency,
        private readonly float $amount,
    ) {
    }

    public function getBaseFromCurrency(): ExchangeRate
    {
        return $this->baseFromCurrency;
    }

    public function getBaseToCurrency(): ExchangeRate
    {
        return $this->baseToCurrency;
    }

    public function getRate(): float
    {
        return $this->amount * $this->baseFromCurrency->getRate();
    }
}
