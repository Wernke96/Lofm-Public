<?php

namespace App\Providers;

use App\Api\Models\Youtube;
use Illuminate\Support\ServiceProvider;

class YoutubeService extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Youtube::class, function () {
            return new Youtube();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
