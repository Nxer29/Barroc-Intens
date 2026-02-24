<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(Request $request)
    { {
            $query = Product::query();

            if ($q = $request->query('q')) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('name', 'like', '%' . $q . '%')
                        ->orWhere('description', 'like', '%' . $q . '%');
                });
            }

            $products = $query->get();

            return view('products.index', ['products' => $products]);
        }
    }

    public function create()
    {
        $categories = ProductCategory::select('id', 'name')->orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->getArr($request);
        $validated['is_visible_to_customers'] = $request->boolean('is_visible_to_customers');

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('status', 'Product created.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::select('id', 'name')->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->getArr($request);
        $data['is_visible_to_customers'] = $request->boolean('is_visible_to_customers');

        $product->update($data);

        return redirect()->route('products.show', $product->id)
            ->with('status', 'Product updated.');
    }
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getArr(Request $request): array
    {
        $data = $request->validate([
            'sku' => ['string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_visible_to_customers' => ['boolean'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
        return $data;
    }
}
