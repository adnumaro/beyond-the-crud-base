<?php

declare(strict_types=1);

namespace Data\CurrencyExchange;

use Domain\ExchangeRate\Models\CurrentCode;
use Domain\ExchangeRate\Models\ExchangeRate;
use Domain\ExchangeRate\Models\ExchangeRateResult;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ExchangeRateClient
{
    private const BASE_URL = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1';

    public function __construct()
    {
    }

    /** @return Collection<CurrentCode> */
    public function getCurrencies(): Collection
    {
        $response = Http
            ::get(static::BASE_URL . '/currencies.min.json')
            ->json();

        $currencyCodes = [];

        foreach ($response as $code => $name) {
            $currencyCodes[] = new CurrentCode($code, $name);
        }

        return collect($currencyCodes);
    }

    public function getExchangeRate(string $from, string $to, float $amount): ExchangeRateResult
    {
        $responseFrom = Http
            ::get(static::BASE_URL . "/currencies/$from.json")
            ->json();

        $responseTo = Http
            ::get(static::BASE_URL . "/currencies/$to.json")
            ->json();

        $exchangeFrom = $responseFrom[$from][$to];
        $exchangeTo = $responseTo[$to][$from];

        return new ExchangeRateResult(
            baseFrom: new ExchangeRate($from, $exchangeFrom),
            baseTo: new ExchangeRate($to, $exchangeTo),
            amount: $amount,
        );
    }
}
