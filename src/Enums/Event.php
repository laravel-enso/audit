<?php

namespace LaravelEnso\Audit\Enums;

use LaravelEnso\Enums\Contracts\Frontend;
use LaravelEnso\Enums\Contracts\Mappable;
use LaravelEnso\Enums\Contracts\Select;
use LaravelEnso\Enums\Traits\Select as Options;

enum Event: int implements Mappable, Select, Frontend
{
    use Options;

    case Created = 1;
    case Updated = 2;
    case Deleted = 3;

    public function map(): string
    {
        return match ($this) {
            self::Created => 'Created',
            self::Updated => 'Updated',
            self::Deleted => 'Deleted',
        };
    }

    public static function registerBy(): string
    {
        return 'auditEvent';
    }
}
