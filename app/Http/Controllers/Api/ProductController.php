<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List products.
     *
     * Hidden products are excluded by default.
     * Use ?include_hidden=1 to include them (for administrative usage).
     */
    public function index(Request $request)
    {
        $includeHidden = filter_var($request->query('include_hidden', false), FILTER_VALIDATE_BOOL);

        $query = Product::query()->with('category');

        if (!$includeHidden) {
            $query->where('is_visible_to_customers', true);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        // Simple search on name / sku / brand
        if ($request->filled('q')) {
            $q = trim((string) $request->query('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        return $query->orderBy('name')->paginate();
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return $product->load('category');
    }

    public function show(Request $request, Product $product)
    {
        $includeHidden = filter_var($request->query('include_hidden', false), FILTER_VALIDATE_BOOL);

        if (!$includeHidden && !$product->is_visible_to_customers) {
            abort(404);
        }

        return $product->load('category');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return $product->load('category');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }
}
