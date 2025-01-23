<?php

namespace Domain\ExchangeRate\Actions;

use Domain\ExchangeRate\Models\ExchangeRateResult;
use Domain\ExchangeRate\Repositories\ExchangeRateRepository;

class GetExchangeRate
{
    public function __construct(private readonly ExchangeRateRepository $exchangeRateRepository)
    {
    }

    public function __invoke(string $fromCurrency, string $toCurrency, float $amount): ExchangeRateResult
    {
        return $this->exchangeRateRepository->getExchangeRate($fromCurrency, $toCurrency, $amount);
    }
}
