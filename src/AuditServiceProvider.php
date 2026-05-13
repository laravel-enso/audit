<?php

namespace LaravelEnso\Audit;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use LaravelEnso\Audit\Services\Models;

class AuditServiceProvider extends EventServiceProvider
{
    public $auditable = [];

    public function boot(): void
    {
        Models::register(array_keys($this->auditable));
    }
}
