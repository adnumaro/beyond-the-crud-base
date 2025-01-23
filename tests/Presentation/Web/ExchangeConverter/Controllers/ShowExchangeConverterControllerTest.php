<?php

declare(strict_types=1);

test('exchange converter screen can be rendered', function (): void {
    $response = $this->get('/exchange-converter');

    $response->assertStatus(200);
});
