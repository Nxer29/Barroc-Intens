<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(Request $request)
    { {
            $query = Product::with(['category', 'images']);

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
        $categories = ProductCategory::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.unique' => 'Deze SKU bestaat al in het systeem.',
            'category_id.exists' => 'De geselecteerde categorie bestaat niet.',
            'name.required' => 'Naam is verplicht.',
            'unit_price.required' => 'Unit prijs is verplicht.',
            'price.required' => 'Prijs is verplicht.',
            'stock.required' => 'Voorraad is verplicht.',
        ]);


        // Extra validatie voor foto's (multiple)
        $request->validate([
            'photos' => ['required', 'array', 'min:1', 'max:3'],
            'photos.*' => [
                'required',
                'file',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:4096',
            ],
        ], [
            'photos.required' => 'Minimaal één foto is verplicht.',
            'photos.min' => 'Upload minimaal één foto.',
            'photos.max' => 'Je kunt maximaal 3 foto\'s uploaden.',
            'photos.*.mimetypes' => 'Alleen JPG, PNG en WebP bestanden zijn toegestaan.',
            'photos.*.max' => 'Elke foto mag maximaal 4MB groot zijn.',
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
        $categories = ProductCategory::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ], [
            'sku.unique' => 'Deze SKU bestaat al in het systeem.',
            'category_id.exists' => 'De geselecteerde categorie bestaat niet.',
            'name.required' => 'Naam is verplicht.',
        ]);

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
