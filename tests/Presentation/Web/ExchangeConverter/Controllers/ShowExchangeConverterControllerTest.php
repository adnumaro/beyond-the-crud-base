<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

test('exchange converter screen can be rendered', function (): void {
    $this->withoutVite();
    $this->withoutMiddleware();

    $this->get('/exchange-converter')
        ->assertInertia(fn(AssertableInertia $page) => $page
        ->component('ExchangeConverter')
    );
});
