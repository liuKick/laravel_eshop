<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Event\ViewEvent;

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
        view()->composer('frontend.layout', function($view){
            $logo = DB::table('logo')
                ->orderByDesc('id')
                ->limit(1)
                ->get();
            return $view->with('Logo', $logo);
        });
        // view()->composer('frontend.layout', function($view){
        //     $Logo = DB::table('logo')
        //                 ->orderBy('id', 'DESC')
        //                 ->limit(1)
        //                 ->get();
        //     return $view->with('Logo', $Logo);
        // });
    }
}
