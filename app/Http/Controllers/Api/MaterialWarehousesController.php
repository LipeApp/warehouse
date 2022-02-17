<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseResource;
use App\Http\Resources\WarehouseCollection;

class MaterialWarehousesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Material $material)
    {
        $this->authorize('view', $material);

        $search = $request->get('search', '');

        $warehouses = $material
            ->warehouses()
            ->search($search)
            ->latest()
            ->paginate();

        return new WarehouseCollection($warehouses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Material $material)
    {
        $this->authorize('create', Warehouse::class);

        $validated = $request->validate([
            'reminder' => ['required', 'numeric'],
        ]);

        $warehouse = $material->warehouses()->create($validated);

        return new WarehouseResource($warehouse);
    }
}
