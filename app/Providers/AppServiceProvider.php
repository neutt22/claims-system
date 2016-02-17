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
        // Current queries: 31
        // Queries down to: 21
        // Queries down to: 19 -> Get all infos table and foreach multiple times
        // Queries down to: 16 -> Get all infos table and foreach multiple times
        // Queries down to: 15 -> Optimizing chart_complete
        // Queries down to: 11 -> Optimizing stages array
        // Queries down to: 7 -> Optimizing claim_status array
        // Queries down to: 4 -> Optimizing claimsAmount(Info) function
        // Queries down to: 3! -> Reusing $infos Collection
        \DB::listen(function($query){
//            \Log::info('Q: ' . $query->sql);
        });
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
