<?php

namespace App\Providers;

use App\Contracts\Posts\PostsFilter;
use App\Services\Posts\BlogPostsFilter;
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
        $this->app->bind(PostsFilter::class, BlogPostsFilter::class);
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
