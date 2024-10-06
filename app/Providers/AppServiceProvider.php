<?php

namespace App\Providers;

use App\Contracts\Posts\BlogPostInterface;
use App\Contracts\Posts\UserPostInterface;
use App\Services\Posts\BlogPostService;
use App\Services\Posts\PostService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BlogPostInterface::class, BlogPostService::class);
        $this->app->bind(UserPostInterface::class, PostService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('date', date('Y'));

        View::composer('user*', function ($view) {
            $view->with('balance', 1234);
        });

        Paginator::useBootstrapFive();
    }
}
