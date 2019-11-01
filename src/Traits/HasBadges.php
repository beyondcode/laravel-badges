<?php

namespace Beyondcode\LaravelBadges\Traits;

use Beyondcode\LaravelBadges\Badge;

trait HasBadges
{
    public function badges()
    {
        return $this->morphToMany(Badge::class, 'model', 'badgeables');
    }
}
