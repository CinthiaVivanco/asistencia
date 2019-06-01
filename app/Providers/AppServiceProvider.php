<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        /*Validator::extend('usuario_encontrado', function($attribute, $value, $parameters) {
            return $value;
        });﻿*/

        Schema::defaultStringLength(191);    
        View::share('capeta', '/asistencia');  
        View::share('version', '20');  
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
