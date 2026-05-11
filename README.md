# Audit

[![License](https://img.shields.io/badge/license-MIT-10b981.svg)](https://github.com/laravel-enso/audit/blob/main/LICENSE)
[![Stable](https://img.shields.io/badge/stable-2.0.0-2563eb.svg)](https://packagist.org/packages/laravel-enso/audit)
[![Downloads](https://img.shields.io/packagist/dm/laravel-enso/audit.svg)](https://packagist.org/packages/laravel-enso/audit)
[![PHP](https://img.shields.io/badge/php-8.2%2B-777bb4.svg)](https://github.com/laravel-enso/audit/blob/main/composer.json)
[![Issues](https://img.shields.io/github/issues/laravel-enso/audit.svg)](https://github.com/laravel-enso/audit/issues)
[![Merge Requests](https://img.shields.io/github/issues-pr/laravel-enso/audit.svg)](https://github.com/laravel-enso/audit/pulls)

## Description

Audit records Eloquent model create, update, and delete events and exposes them through an Enso table endpoint.

The package does not auto-discover auditable models. Each application or package must explicitly attach `LaravelEnso\Audit\Observers\ModelObserver` to the models it wants audited.

## Installation

Install the package:

```bash
composer require laravel-enso/audit
```

Run the package migrations:

```bash
php artisan migrate
```

## Features

- Stores `created`, `updated`, and `deleted` events together with before/after payloads.
- Uses explicit observer registration per model.
- Supports restricted payloads through an `auditableAttributes()` method or `$auditableAttributes` model property.
- Publishes table-init, table-data, export, and options endpoints under `api/system/audit`.

## Usage

Register the observer from the consuming application or package service provider:

```php
namespace App\Providers;

use App\Models\Invoice;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Audit\Observers\ModelObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Invoice::observe(ModelObserver::class);
    }
}
```

By default, all model attributes are recorded.

To limit the recorded payload, define either an `auditableAttributes()` method or an `$auditableAttributes` property on the model:

```php
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public array $auditableAttributes = ['status', 'total'];
}
```

or:

```php
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function auditableAttributes(): array
    {
        return ['status', 'total'];
    }
}
```

## Upgrade Guide

### 2.0.0

This is a breaking release.

Auditable model discovery was removed. Models are no longer detected through `Auditable` or `RestrictedAuditable` contracts, and the package no longer registers observers automatically.

Attach `LaravelEnso\Audit\Observers\ModelObserver` manually on each model that should be audited. To restrict the recorded payload, define an `auditableAttributes()` method or a public `$auditableAttributes` property on that model.

## API

### Main route group

Mounted under `api/system/audit`:

- `system.audit.initTable`
- `system.audit.tableData`
- `system.audit.exportExcel`
- `system.audit.options`

### Core classes

- `LaravelEnso\Audit\Observers\ModelObserver`
- `LaravelEnso\Audit\Models\Audit`

## Depends On

Required Enso packages:

- [`laravel-enso/enums`](https://github.com/laravel-enso/enums)
- [`laravel-enso/migrator`](https://github.com/laravel-enso/migrator)
- [`laravel-enso/select`](https://docs.laravel-enso.com/backend/select.html)
- [`laravel-enso/tables`](https://docs.laravel-enso.com/backend/tables.html)
- [`laravel-enso/track-who`](https://docs.laravel-enso.com/backend/track-who.html)
- [`laravel-enso/users`](https://github.com/laravel-enso/users)

Companion frontend package:

- [`@enso-ui/audit`](https://docs.laravel-enso.com/frontend/audit.html) [↗](https://github.com/enso-ui/audit)

## Contributions

are welcome. Pull requests are great, but issues are good too.

Thank you to all the people who already contributed to Enso!

## License

[MIT](https://github.com/laravel-enso/audit/blob/main/LICENSE)
