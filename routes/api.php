<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Audit\Http\Controllers\Audit\ExportExcel;
use LaravelEnso\Audit\Http\Controllers\Audit\InitTable;
use LaravelEnso\Audit\Http\Controllers\Audit\Models;
use LaravelEnso\Audit\Http\Controllers\Audit\TableData;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/system/audit')
    ->as('system.audit.')
    ->group(function () {
        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
        Route::get('exportExcel', ExportExcel::class)->name('exportExcel');
        Route::get('models', Models::class)->name('models');
    });
