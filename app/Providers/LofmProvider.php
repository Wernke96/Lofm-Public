<?php

namespace App\Providers;

use App\Lofm\Domain\Repositories\LofmUserRepository;
use App\Lofm\Domain\Services\UserService;
use App\Lofm\Infrastructure\Jenssegers\Repository\UserRepository;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class LofmProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(LofmUserRepository::class, function (){
            return new UserRepository(
                resolve(User::class),
                resolve(Hasher::class),
                resolve(LoggerInterface::class)
            );
        });

        $this->app->singleton(UserService::class, function (){
            return new UserService(resolve(LofmUserRepository::class));
        });
    }
}
