<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Material;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialProductsTest extends TestCase
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
    public function it_gets_material_products()
    {
        $material = Material::factory()->create();
        $product = Product::factory()->create();

        $material->products()->attach($product);

        $response = $this->getJson(
            route('api.materials.products.index', $material)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_material()
    {
        $material = Material::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.materials.products.store', [$material, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $material
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_material()
    {
        $material = Material::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.materials.products.store', [$material, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $material
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}
