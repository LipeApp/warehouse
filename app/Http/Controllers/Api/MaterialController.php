<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\MaterialCollection;
use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;

class MaterialController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Material::class);

        $search = $request->get('search', '');

        $materials = Material::search($search)
            ->latest()
            ->paginate();

        return new MaterialCollection($materials);
    }

    /**
     * @param \App\Http\Requests\MaterialStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialStoreRequest $request)
    {
        $this->authorize('create', Material::class);

        $validated = $request->validated();

        $material = Material::create($validated);

        return new MaterialResource($material);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Material $material)
    {
        $this->authorize('view', $material);

        return new MaterialResource($material);
    }

    /**
     * @param \App\Http\Requests\MaterialUpdateRequest $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialUpdateRequest $request, Material $material)
    {
        $this->authorize('update', $material);

        $validated = $request->validated();

        $material->update($validated);

        return new MaterialResource($material);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Material $material)
    {
        $this->authorize('delete', $material);

        $material->delete();

        return response()->noContent();
    }
}
