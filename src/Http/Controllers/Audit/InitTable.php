<?php

namespace LaravelEnso\Audit\Http\Controllers\Audit;

use Illuminate\Routing\Controller;
use LaravelEnso\Audit\Tables\Builders\Audit;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected string $tableClass = Audit::class;
}
