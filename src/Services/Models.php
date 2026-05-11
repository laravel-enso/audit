<?php

namespace LaravelEnso\Audit\Services;

use Illuminate\Support\Collection;

class Models
{
    public static array $models = [];

    public static function register(array $models): void
    {
        self::$models = Collection::wrap(self::$models)
            ->merge($models)
            ->unique()
            ->sort()
            ->values()
            ->all();
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
