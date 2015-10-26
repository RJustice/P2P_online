<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->middleware('member.auth', \App\Http\Middleware\MemberAuthenticate::class);
        $this->app['router']->middleware('member.guest', \App\Http\Middleware\RedirectIfAuthenticated::class);
        // $this->app->bind('Illuminate\Contracts\Auth\Guard','App\Services\CustomGuard');
        $this->app['router']->middleware('admin.auth', \App\Http\Middleware\AdminAuthenticate::class);
        
        $this->app->register(IFormServiceProvider::class);
        $this->app->register(IHtmlServiceProvider::class);
    }
}
