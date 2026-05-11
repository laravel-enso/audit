<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration {
    protected array $permissions = [
        ['name' => 'system.audit.index', 'description' => 'Show index for audit', 'is_default' => false],
        ['name' => 'system.audit.initTable', 'description' => 'Init table for audit', 'is_default' => false],
        ['name' => 'system.audit.tableData', 'description' => 'Get table data for audit', 'is_default' => false],
        ['name' => 'system.audit.exportExcel', 'description' => 'Export excel for audit', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Audit', 'icon' => 'poll', 'route' => 'system.audit.index', 'order_index' => 150, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'System';
};
