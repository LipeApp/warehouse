<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.materials.index', compact('materials', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Material::class);

        return view('app.materials.create');
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

        return redirect()
            ->route('materials.edit', $material)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Material $material)
    {
        $this->authorize('view', $material);

        return view('app.materials.show', compact('material'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        return view('app.materials.edit', compact('material'));
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

        return redirect()
            ->route('materials.edit', $material)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('materials.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
