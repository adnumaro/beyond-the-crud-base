<?php

declare(strict_types=1);

namespace Presentation\Web\Dashboard\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Presentation\Controller;

class ShowDashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard');
    }
}
