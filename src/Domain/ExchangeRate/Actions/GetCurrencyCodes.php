<?php

namespace Domain\ExchangeRate\Actions;

use Domain\ExchangeRate\Repositories\ExchangeRateRepository;
use Illuminate\Support\Collection;

class GetCurrencyCodes
{
    public function __construct(private readonly ExchangeRateRepository $exchangeRateRepository)
    {
    }

    public function __invoke(): Collection
    {
        return $this->exchangeRateRepository->getCurrencyCodes();
    }
}
