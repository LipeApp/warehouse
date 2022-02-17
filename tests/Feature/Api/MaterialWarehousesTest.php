<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Material;
use App\Models\Warehouse;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialWarehousesTest extends TestCase
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
    public function it_gets_material_warehouses()
    {
        $material = Material::factory()->create();
        $warehouses = Warehouse::factory()
            ->count(2)
            ->create([
                'material_id' => $material->id,
            ]);

        $response = $this->getJson(
            route('api.materials.warehouses.index', $material)
        );

        $response->assertOk()->assertSee($warehouses[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_material_warehouses()
    {
        $material = Material::factory()->create();
        $data = Warehouse::factory()
            ->make([
                'material_id' => $material->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.materials.warehouses.store', $material),
            $data
        );

        $this->assertDatabaseHas('warehouses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $warehouse = Warehouse::latest('id')->first();

        $this->assertEquals($material->id, $warehouse->material_id);
    }
}
