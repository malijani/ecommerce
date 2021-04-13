<?php

namespace App\Providers;

use App\Logo;
use App\TopNav;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $logo = Logo::withoutTrashed()->where('status', '1')->first();
        View::share('logo', $logo);

        $top_navs_medium = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 1)
            ->orderBy('id')
            ->orderByDesc('status')
            ->get();
        View::share('top_navs_medium', $top_navs_medium);

        $top_navs_small = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 0)
            ->orderByDesc('id')
            ->get();
        View::share('top_navs_small', $top_navs_small);
    }
}
