<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Material;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductMaterialsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_product_materials()
    {
        $product = Product::factory()->create();
        $material = Material::factory()->create();

        $product->materials()->attach($material);

        $response = $this->getJson(
            route('api.products.materials.index', $product)
        );

        $response->assertOk()->assertSee($material->name);
    }

    /**
     * @test
     */
    public function it_can_attach_materials_to_product()
    {
        $product = Product::factory()->create();
        $material = Material::factory()->create();

        $response = $this->postJson(
            route('api.products.materials.store', [$product, $material])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->materials()
                ->where('materials.id', $material->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_materials_from_product()
    {
        $product = Product::factory()->create();
        $material = Material::factory()->create();

        $response = $this->deleteJson(
            route('api.products.materials.store', [$product, $material])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->materials()
                ->where('materials.id', $material->id)
                ->exists()
        );
    }
}
