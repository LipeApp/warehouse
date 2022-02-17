<?php

namespace App\Http\Controllers\Api;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseResource;
use App\Http\Resources\WarehouseCollection;
use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Requests\WarehouseUpdateRequest;

class WarehouseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Warehouse::class);

        $search = $request->get('search', '');

        $warehouses = Warehouse::search($search)
            ->latest()
            ->paginate();

        return new WarehouseCollection($warehouses);
    }

    /**
     * @param \App\Http\Requests\WarehouseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseStoreRequest $request)
    {
        $this->authorize('create', Warehouse::class);

        $validated = $request->validated();

        $warehouse = Warehouse::create($validated);

        return new WarehouseResource($warehouse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Warehouse $warehouse)
    {
        $this->authorize('view', $warehouse);

        return new WarehouseResource($warehouse);
    }

    /**
     * @param \App\Http\Requests\WarehouseUpdateRequest $request
     * @param \App\Models\Warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(
        WarehouseUpdateRequest $request,
        Warehouse $warehouse
    ) {
        $this->authorize('update', $warehouse);

        $validated = $request->validated();

        $warehouse->update($validated);

        return new WarehouseResource($warehouse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Warehouse $warehouse)
    {
        $this->authorize('delete', $warehouse);

        $warehouse->delete();

        return response()->noContent();
    }
}
