<?php

namespace Rogner\Erede\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EredeServiceProvider
 * @package Rogner\Erede\Providers
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
