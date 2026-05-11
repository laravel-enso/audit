<?php

namespace LaravelEnso\Audit\Http\Controllers\Audit;

use Illuminate\Routing\Controller;
use LaravelEnso\Audit\Tables\Builders\Audit;
use LaravelEnso\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected string $tableClass = Audit::class;
}
