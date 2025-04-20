<?php

namespace RupantorPay;

use Illuminate\Support\ServiceProvider;

class RupantorPayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RupantorPay::class, function () {
            return new RupantorPay();
        });
    }

    public function boot()
    {
        //
    }
}
