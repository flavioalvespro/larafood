<?php

namespace Tests\Feature\Api;

use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * Error get tables by tenant
     *
     * @return void
     */
    public function testGetTablesByTenantError()
    {
        $response = $this->getJson('/api/v1/tables');

        $response->assertStatus(422);
    }

    /**
     * get tables by tenant
     *
     * @return void
     */
    public function testGetTablesByTenant()
    {
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/tables?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Error get table by identify
     *
     * @return void
     */
    public function testGetTableByIdentifyError()
    {
        $table = 'fake_value';
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/tables/{$table}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * get table by identify
     *
     * @return void
     */
    public function testGetTableByIdentify()
    {
        $table = factory(Table::class)->create();
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/tables/{$table->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
