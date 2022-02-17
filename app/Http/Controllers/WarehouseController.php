<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Warehouse;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.warehouses.index', compact('warehouses', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Warehouse::class);

        $materials = Material::pluck('name', 'id');

        return view('app.warehouses.create', compact('materials'));
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

        return redirect()
            ->route('warehouses.edit', $warehouse)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Warehouse $warehouse)
    {
        $this->authorize('view', $warehouse);

        return view('app.warehouses.show', compact('warehouse'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Warehouse $warehouse)
    {
        $this->authorize('update', $warehouse);

        $materials = Material::pluck('name', 'id');

        return view('app.warehouses.edit', compact('warehouse', 'materials'));
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

        return redirect()
            ->route('warehouses.edit', $warehouse)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('warehouses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
