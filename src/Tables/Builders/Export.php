<?php

namespace LaravelEnso\Audit\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;

class Export extends Audit
{
    public function query(): Builder
    {
        return parent::query()->withCasts(['changes' => 'string']);
    }
}
