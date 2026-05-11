<?php

namespace LaravelEnso\Audit\Observers;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;
use LaravelEnso\Audit\Enums\Event;
use LaravelEnso\Audit\Models\Audit as Model;

class Audit
{
    public function created(EloquentModel $model): void
    {
        $attributes = $this->attributes($model);

        $audit = $attributes
            ? $model->only($attributes)
            : $model->getAttributes();

        $this->log(Event::Created, $model, $audit);
    }

    public function updated(EloquentModel $model): void
    {
        $attributes = $this->attributes($model);

        $after = $attributes
            ? Arr::only($model->getChanges(), $attributes)
            : $model->getChanges();

        $before = Arr::only($model->getPrevious(), array_keys($after));

        $audit = ['before' => $before, 'after' => $after];

        $this->log(Event::Updated, $model, $audit);
    }

    public function deleted(EloquentModel $model): void
    {
        $attributes = $this->attributes($model);

        $audit = $attributes
            ? $model->only($attributes)
            : $model->getAttributes();

        $this->log(Event::Deleted, $model, $audit);
    }

    protected function log(Event $event, EloquentModel $model, array $audit): void
    {
        Model::create([
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
            'changes' => $audit,
        ]);
    }

    private function attributes(EloquentModel $model): ?array
    {
        return method_exists($model, 'auditableAttributes')
            ? $model->auditableAttributes()
            : null;
    }
}
