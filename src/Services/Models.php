<?php

namespace LaravelEnso\Audit\Services;

use Illuminate\Support\Collection;
use LaravelEnso\Audit\Observers\Audit;

class Models
{
    private static array $models = [];

    public static function register(array $models): void
    {
        self::$models = Collection::wrap($models)
            ->unique()->sort()->values()->all();

        Collection::wrap($models)
            ->each(fn ($model) => $model::observe(Audit::class));
    }

    public static function options(): Collection
    {
        return Collection::wrap(self::$models)
            ->map(fn (string $model) => [
                'label' => $model,
                'value' => $model,
            ])->values();
    }
}
