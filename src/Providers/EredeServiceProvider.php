<?php

namespace Bagisto\Erede\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EredeServiceProvider
 * @package Bagisto\Erede\Providers
 */
class EredeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'paymentmethods'
        );
    }
}
