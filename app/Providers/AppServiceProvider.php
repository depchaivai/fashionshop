<?php

namespace App\Providers;

use App\Models\Cate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url)
    {
        $mymenu = Cate::all();
        View::share('allmenu', $mymenu);
        if(env('APP_ENV') !== 'local')
        {
            $url->forceScheme('https');
        }
    }
}
