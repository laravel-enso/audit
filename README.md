# Audit

[![License](https://img.shields.io/badge/license-MIT-10b981.svg)](https://github.com/laravel-enso/audit/blob/main/LICENSE)
[![Stable](https://img.shields.io/badge/stable-2.0.2-2563eb.svg)](https://packagist.org/packages/laravel-enso/audit)
[![Downloads](https://img.shields.io/packagist/dm/laravel-enso/audit.svg)](https://packagist.org/packages/laravel-enso/audit)
[![PHP](https://img.shields.io/badge/php-8.2%2B-777bb4.svg)](https://github.com/laravel-enso/audit/blob/main/composer.json)
[![Issues](https://img.shields.io/github/issues/laravel-enso/audit.svg)](https://github.com/laravel-enso/audit/issues)
[![Merge Requests](https://img.shields.io/github/issues-pr/laravel-enso/audit.svg)](https://github.com/laravel-enso/audit/pulls)

## Description

Audit records Eloquent model create, update, and delete events and exposes them through an Enso table endpoint.

The package does not auto-discover auditable models. Each application or package must explicitly attach `LaravelEnso\Audit\Observers\Audit` to the models it wants audited.

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
- Supports restricted payloads through an `auditableAttributes()` method on the audited model.
- Collects observed model classes and exposes them as select options for the frontend model filter.
- Stores the actor through `track-who` on the audit record itself.
- Publishes table-init, table-data, export, and model-options endpoints under `api/system/audit`.

## Usage

Register the observer from the consuming application or package service provider:

```php
namespace App\Providers;

use App\Models\Invoice;
use LaravelEnso\Audit\AuditServiceProvider as ServiceProvider;
use LaravelEnso\Audit\Observers\Audit;

class AuditServiceProvider extends ServiceProvider
{
    public $observers = [
        Invoice::class => [Audit::class],
    ];
}
```

By default, all model attributes are recorded.

To limit the recorded payload, define an `auditableAttributes()` method on the model:

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

### 2.0.2

Observed model classes are now collected from `AuditServiceProvider::$observers` and exposed through `system.audit.models` / `GET api/system/audit/models` for frontend model filters.

### 2.0.0

This is a breaking release.

Auditable model discovery was removed. Models are no longer detected automatically, and the package no longer registers observers on its own.

Attach `LaravelEnso\Audit\Observers\Audit` manually on each model that should be audited. To restrict the recorded payload, define an `auditableAttributes()` method on that model.

## API

### Main route group

Mounted under `api/system/audit`:

- `system.audit.initTable`
- `system.audit.tableData`
- `system.audit.exportExcel`
- `system.audit.models`

The model options route returns the audited models registered through the audit service provider:

- `GET api/system/audit/models`

### Core classes

- `LaravelEnso\Audit\AuditServiceProvider`
- `LaravelEnso\Audit\Observers\Audit`
- `LaravelEnso\Audit\Models\Audit`
- `LaravelEnso\Audit\Services\Models`

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
