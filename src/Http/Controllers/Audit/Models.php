<?php

namespace LaravelEnso\Audit\Http\Controllers\Audit;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use LaravelEnso\Audit\Services\Models as Service;

class Models extends Controller
{
    public function __invoke(): Collection
    {
        return Service::options();
    }
}
