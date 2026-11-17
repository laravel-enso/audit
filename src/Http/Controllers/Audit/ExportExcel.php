<?php

namespace LaravelEnso\Audit\Http\Controllers\Audit;

use Illuminate\Routing\Controller;
use LaravelEnso\Audit\Tables\Builders\Export;
use LaravelEnso\Tables\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected string $tableClass = Export::class;
}
