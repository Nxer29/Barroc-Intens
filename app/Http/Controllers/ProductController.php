<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PHPUnit\Event\DeferringDispatcher;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        {
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
            return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $this->getArr($request);


        // Extra validatie voor foto's (multiple)
        $request->validate([
            'photos' => ['required', 'array', 'min:1', 'max:3'],
            'photos.*' => [
                'required',
                'file',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
            ],
        ]);

        $validated['is_visible_to_customers'] = $request->boolean('is_visible_to_customers');

        $product = Product::create($validated);

        foreach ($request->file('photos', []) as $photo) {
            $path = $photo->store("products/{$product->id}", 'public');

            // Vereist: $product->images() relatie + ProductImage model/table
            $product->images()->create([
                'path' => $path,
            ]);
        }

        return redirect()->route('products.index')
            ->with('status', 'Product created.');
    }


    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
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
        return $request->validate([
            'sku' => ['string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            // beter: sometimes i.p.v required, want checkbox kan ontbreken
            'is_visible_to_customers' => ['sometimes', 'boolean'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }
}
