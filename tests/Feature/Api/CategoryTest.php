<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * Error get categories by tenant
     *
     * @return void
     */
    public function testGetCategoriesByTenantError()
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(422);
    }

    /**
     * get categories by tenant
     *
     * @return void
     */
    public function testGetCategoriesByTenant()
    {
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/categories?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Error get category by identify
     *
     * @return void
     */
    public function testGetCategoryByIdentifyError()
    {
        $category = 'fake_value';
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/categories/{$category}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * get category by identify
     *
     * @return void
     */
    public function testGetCategoryByIdentify()
    {
        $category = factory(Category::class)->create();
        $tenant = factory(Tenant::class)->create();

        $response = $this->getJson("/api/v1/categories/{$category->uuid}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }
}
