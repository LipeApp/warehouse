<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class MaterialProductsController extends Controller
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

        $products = $material
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Material $material,
        Product $product
    ) {
        $this->authorize('update', $material);

        $material->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Material $material,
        Product $product
    ) {
        $this->authorize('update', $material);

        $material->products()->detach($product);

        return response()->noContent();
    }
}
