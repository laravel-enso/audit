<?php

namespace LaravelEnso\Audit\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Audit\Models\Audit as Model;
use LaravelEnso\Tables\Contracts\Table;

class Audit implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/audits.json';

    public function query(): Builder
    {
        $select = [
            'id', 'event', 'auditable_type', 'auditable_id', 'changes',
            'created_by', 'created_at',
        ];

        return Model::with(['createdBy.avatar', 'createdBy.person'])
            ->select($select);
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
