<?php

namespace Beyondcode\LaravelBadges;

use Illuminate\Support\Facades\Event;

class BadgeProvider
{
    protected $badge;
    protected $model;
    protected $condition;

    public function grant($badge)
    {
        $this->badge = $badge;

        return $this;
    }

    public function to($model)
    {
        $this->model = $model;

        return $this;
    }

    public function when($condition)
    {
        $this->condition = $condition;

        $this->applyBadges();
    }

    protected function applyBadges()
    {
        $badge = Badge::where('name', $this->badge)->firstOrFail();

        Event::listen('eloquent.saved: '.$this->model, function ($model) use ($badge) {
            if (call_user_func($this->condition, $model) === true) {
                $model->badges()->syncWithoutDetaching([$badge->id]);
            }
        });
    }
}
