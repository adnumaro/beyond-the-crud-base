<?php

namespace Domain\ExchangeRate\Actions;

use Domain\ExchangeRate\Models\ExchangeRateResult;
use Domain\ExchangeRate\Repositories\ExchangeRateRepository;

class GetExchangeRate
{
    public function __construct(private readonly ExchangeRateRepository $exchangeRateRepository)
    {
    }

    public function __invoke(string $from, string $to, float $amount): ExchangeRateResult
    {
        return $this->exchangeRateRepository->getExchangeRate($from, $to, $amount);
    }
}
