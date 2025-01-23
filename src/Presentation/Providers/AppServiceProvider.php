<?php

declare(strict_types=1);

namespace Presentation\Providers;

use Carbon\CarbonImmutable;
use Data\CurrencyExchange\ExchangeRateClient;
use Data\CurrencyExchange\ExchangeRateRepositoryImpl;
use Domain\ExchangeRate\Repositories\ExchangeRateRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Date::use(CarbonImmutable::class);

        $this->app->bind(
            ExchangeRateRepository::class,
            fn () => new ExchangeRateRepositoryImpl(new ExchangeRateClient),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(fn (string $modelName): string => 'Database\\Factories\\'.Str::after($modelName, 'Domain\\').'Factory');
        Factory::guessModelNamesUsing(fn (Factory $factory): string => Str::replaceLast(
            'Factory',
            '',
            Str::replaceFirst('Database\\Factories\\', 'Domain\\', $factory::class),
        ));
    }
}
