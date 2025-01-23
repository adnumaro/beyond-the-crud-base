<?php

declare(strict_types=1);

namespace Presentation\Web\Dashboard\Controllers;

use Domain\ExchangeRate\Actions\GetCurrencyCodes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Presentation\Controller;

class ShowDashboardController extends Controller
{
    public function __invoke(Request $request, GetCurrencyCodes $getCurrencyCodes): Response
    {
        $currencyCodes = $getCurrencyCodes()->map(fn ($currencyCode) => [
            'value' => $currencyCode->getCode(),
            'label' => "{$currencyCode->getCode()} - {$currencyCode->getName()}",
        ]);
        return Inertia::render('Dashboard', [
            'currencyCodes' => $currencyCodes->toArray(),
        ]);
    }
}
