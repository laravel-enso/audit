<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Audit\Enums\Event;
use LaravelEnso\Audit\Models\Audit as AuditModel;
use LaravelEnso\Audit\Observers\Audit;
use LaravelEnso\Audit\Services\Models;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\People\Models\Person;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Models::$models = [];
    }

    #[Test]
    public function it_registers_model_options_from_observed_models(): void
    {
        Models::register([Person::class, Company::class, Person::class]);

        $this->assertSame([
            [
                'label' => 'Company',
                'value' => Company::class,
            ],
            [
                'label' => 'Person',
                'value' => Person::class,
            ],
        ], Models::options()->all());
    }

    #[Test]
    public function it_exposes_registered_models_through_options_endpoint(): void
    {
        $this->seed()
            ->actingAs(User::first());

        User::first()->role->permissions()->sync(Permission::pluck('id'));

        Models::register([Person::class]);

        $this->get(route('system.audit.models', [], false))
            ->assertOk()
            ->assertExactJson([
                [
                    'label' => 'Person',
                    'value' => Person::class,
                ],
            ]);
    }

    #[Test]
    public function it_logs_restricted_created_updated_and_deleted_model_events(): void
    {
        $this->createAuditableTable();

        AuditTestModel::observe(Audit::class);

        $model = AuditTestModel::create([
            'name' => 'initial',
            'ignored' => 'first',
        ]);

        $model->update([
            'name' => 'updated',
            'ignored' => 'second',
        ]);

        $model->delete();

        $audits = AuditModel::orderBy('id')->get();

        $this->assertCount(3, $audits);

        $this->assertSame(Event::Created, $audits[0]->event);
        $this->assertSame(['name' => 'initial'], $audits[0]->changes);

        $this->assertSame(Event::Updated, $audits[1]->event);
        $this->assertSame([
            'before' => ['name' => 'initial'],
            'after' => ['name' => 'updated'],
        ], $audits[1]->changes);

        $this->assertSame(Event::Deleted, $audits[2]->event);
        $this->assertSame(['name' => 'updated'], $audits[2]->changes);
    }

    private function createAuditableTable(): void
    {
        Schema::create('audit_test_models', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('ignored');
            $table->timestamps();
        });
    }
}

class AuditTestModel extends Model
{
    protected $guarded = [];

    public function auditableAttributes(): array
    {
        return ['name'];
    }
}
