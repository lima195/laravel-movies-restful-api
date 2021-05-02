<?php

namespace App\Providers;

use App\Repository\EloquentRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\MovieRepositoryInterface;
use App\Repository\Eloquent\MovieRepository;
use App\Repository\MovieLogRepositoryInterface;
use App\Repository\Eloquent\MovieLogRepository;
use App\Repository\MovieLikeRepositoryInterface;
use App\Repository\Eloquent\MovieLikeRepository;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(MovieLogRepositoryInterface::class, MovieLogRepository::class);
        $this->app->bind(MovieLikeRepositoryInterface::class, MovieLikeRepository::class);
    }
}
