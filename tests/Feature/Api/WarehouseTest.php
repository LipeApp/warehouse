<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Warehouse;

use App\Models\Material;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WarehouseTest extends TestCase
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
    public function it_gets_warehouses_list()
    {
        $warehouses = Warehouse::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.warehouses.index'));

        $response->assertOk()->assertSee($warehouses[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_warehouse()
    {
        $data = Warehouse::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.warehouses.store'), $data);

        $this->assertDatabaseHas('warehouses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_warehouse()
    {
        $warehouse = Warehouse::factory()->create();

        $material = Material::factory()->create();

        $data = [
            'reminder' => $this->faker->randomNumber(2),
            'material_id' => $material->id,
        ];

        $response = $this->putJson(
            route('api.warehouses.update', $warehouse),
            $data
        );

        $data['id'] = $warehouse->id;

        $this->assertDatabaseHas('warehouses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_warehouse()
    {
        $warehouse = Warehouse::factory()->create();

        $response = $this->deleteJson(
            route('api.warehouses.destroy', $warehouse)
        );

        $this->assertDeleted($warehouse);

        $response->assertNoContent();
    }
}
