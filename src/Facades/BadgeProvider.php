<?php

namespace Beyondcode\LaravelBadges\Facades;

use Illuminate\Support\Facades\Facade;

class BadgeProvider extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Beyondcode\LaravelBadges\BadgeProvider::class;
    }
}
