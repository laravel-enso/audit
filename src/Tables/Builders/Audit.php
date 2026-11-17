<?php

namespace LaravelEnso\Audit\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Audit\Models\Audit as Model;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Tables\Contracts\CustomFilter;
use LaravelEnso\Tables\Contracts\Table;

class Audit implements Table, CustomFilter
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

    public function filterApplies(Obj $params): bool
    {
        return $params->filled('roleId');
    }

    public function filter(Builder $query, Obj $params): void
    {
        $query->whereHas('createdBy', fn (Builder $user) => $user
            ->where('role_id', $params->get('roleId')));
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
