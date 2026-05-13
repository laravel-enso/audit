<?php

namespace LaravelEnso\Audit;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaravelEnso\Audit\Services\Models;

class AuditServiceProvider extends EventServiceProvider
{
    public $models = [];

    public function boot(): void
    {
        Models::register($this->models);
    }
}
