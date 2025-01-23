<?php

declare(strict_types=1);


use Data\CurrencyExchange\ExchangeRateClient;
use Domain\ExchangeRate\Models\ExchangeRate;
use Domain\ExchangeRate\Models\ExchangeRateResult;
use Domain\User\Models\User;

test('exchange converter screen can be rendered', function (): void {
    $this->actingAs(User::factory()->create());

    $this->mock(ExchangeRateClient::class, function ($mock): void {
        $mock->shouldReceive('getExchangeRate')->with('usd', 'eur', 100)
            ->andReturn(new ExchangeRateResult(
                new ExchangeRate('usd', 0.96),
                new ExchangeRate('eur', 1.04),
                100
            ));
    });

    $response = $this->post('/exchange-converter/convert', [
        'from_currency' => 'usd',
        'to_currency' => 'eur',
        'amount' => 100,
    ]);

    $response->assertStatus(302)->assertSessionHas('data', [
        'baseFromCurrencyRate' => 0.96,
        'baseToCurrencyRate' => 1.04,
        'ratedAmount' => 96.03,
    ]);
});
