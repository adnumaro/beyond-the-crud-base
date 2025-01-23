<?php

namespace Data\CurrencyExchange;

use Domain\ExchangeRate\Models\CurrentCode;
use Domain\ExchangeRate\Models\ExchangeRateResult;
use Domain\ExchangeRate\Repositories\ExchangeRateRepository;
use Illuminate\Support\Collection;

class ExchangeRateRepositoryImpl implements ExchangeRateRepository
{
    public function __construct(private readonly ExchangeRateClient $exchangeRateClient)
    {
    }

    /** @return Collection<CurrentCode> */
    public function getCurrencyCodes(): Collection
    {
        return $this->exchangeRateClient->getCurrencies();
    }

    public function getExchangeRate(
        string $fromCurrency,
        string $toCurrency,
        float $amount
    ): ExchangeRateResult {
        return $this->exchangeRateClient->getExchangeRate($fromCurrency, $toCurrency, $amount);
    }
}
