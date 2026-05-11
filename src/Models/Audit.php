<?php

namespace LaravelEnso\Audit\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Audit\Enums\Event;
use LaravelEnso\Tables\Traits\TableCache;
use LaravelEnso\TrackWho\Traits\CreatedBy;

class Audit extends Model
{
    use TableCache, CreatedBy;

    public const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'event' => Event::class,
        'changes' => 'array',
    ];
}
