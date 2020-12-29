<?php

namespace Creagia\NovaPercentageCard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/nova-percentage-card'),
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-percentage-card', __DIR__ . '/../dist/js/card.js');
            Nova::translations(resource_path('lang/vendor/nova-percentage-card/' . app()->getLocale() . '.json'));
        });
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/nova-percentage-card')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
