<?php

declare(strict_types=1);

namespace Presentation\Web\Dashboard\Controllers;

use Domain\ExchangeRate\Actions\GetExchangeRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Presentation\Controller;

class ConvertCurrencyController extends Controller
{
    public function __invoke(Request $request, GetExchangeRate $getExchangeRate): RedirectResponse
    {
        $validated = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $rate = $getExchangeRate(
            from: $validated['from'],
            to: $validated['to'],
            amount: $validated['amount'],
        );

        return back()->with([
            'data' => [
                'ratedAmount' => round($rate->getRate(), 2),
                'baseToRate' => round($rate->getBaseTo()->getRate(), 2),
                'baseFromRate' => round($rate->getBaseFrom()->getRate(), 2),
            ],
        ]);
    }
}
