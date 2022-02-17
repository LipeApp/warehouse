<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialCollection;

class ProductMaterialsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $materials = $product
            ->materials()
            ->search($search)
            ->latest()
            ->paginate();

        return new MaterialCollection($materials);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Material $material
    ) {
        $this->authorize('update', $product);

        $product->materials()->syncWithoutDetaching([$material->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        Material $material
    ) {
        $this->authorize('update', $product);

        $product->materials()->detach($material);

        return response()->noContent();
    }
}
