<?php

namespace Beyondcode\LaravelBadges;

use Illuminate\Support\ServiceProvider;

class BadgesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/create_badges_table.php' =>
            database_path('migrations/'.date('dmYHis').'_create_badges_table.php')
        ]);
    }
}
