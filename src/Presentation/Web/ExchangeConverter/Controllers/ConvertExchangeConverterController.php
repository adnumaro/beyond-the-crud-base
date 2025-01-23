<?php

declare(strict_types=1);

namespace Presentation\Web\ExchangeConverter\Controllers;

use Domain\ExchangeRate\Actions\GetExchangeRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Controller;

class ConvertExchangeConverterController extends Controller
{
    public function __invoke(Request $request, GetExchangeRate $getExchangeRate): RedirectResponse
    {
        $validated = $request->validate([
            'from_currency' => 'required|string',
            'to_currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $rate = $getExchangeRate(
            fromCurrency: $validated['from_currency'],
            toCurrency: $validated['to_currency'],
            amount: $validated['amount'],
        );

        return back()->with([
            'data' => [
                'baseFromCurrencyRate' => round($rate->getBaseFromCurrency()->getRate(), 2),
                'baseToCurrencyRate' => round($rate->getBaseToCurrency()->getRate(), 2),
                'ratedAmount' => round($rate->getRate(), 2),
            ],
        ]);
    }
}
