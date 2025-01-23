<?php

declare(strict_types=1);

namespace Domain\ExchangeRate\Repositories;

use Domain\ExchangeRate\Models\ExchangeRate;
use Domain\ExchangeRate\Models\ExchangeRateResult;
use Illuminate\Support\Collection;

interface ExchangeRateRepository
{
    /** @return Collection<ExchangeRate> */
    public function getCurrencyCodes(): Collection;

    public function getExchangeRate(string $fromCurrency, string $toCurrency, float $amount): ExchangeRateResult;
}
