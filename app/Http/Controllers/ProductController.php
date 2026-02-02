<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function demoProducts()
    {
        return collect([
            (object)['id'=>1,'name'=>'Barroc Machine A','category'=>'Koffiemachine','price'=>'€1200','stock'=>10,'description'=>'Professionele koffiemachine.'],
            (object)['id'=>2,'name'=>'Bonen Premium','category'=>'Bonen','price'=>'€25','stock'=>200,'description'=>'Donkere branding, intens aroma.'],
            (object)['id'=>3,'name'=>'Reservoir sensor','category'=>'Onderdeel','price'=>'€89.99','stock'=>2,'description'=>'Sensor voor waterreservoir.'],
        ]);
    }

    public function index(Request $request)
    {
        $products = $this->demoProducts();

        if ($q = $request->query('q')) {
            $products = $products->filter(fn($p) =>
                str_contains(strtolower($p->name.' '.$p->description), strtolower($q))
            );
        }

        return view('products.index', ['products' => $products]);
    }


    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $this->getArr($request);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('status', 'Product created.');
    }

    public function show($id)
    {
        $product = $this->demoProducts()->firstWhere('id', (int)$id);
        abort_unless($product, 404);
        return view('products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->getArr($request);

        $data['is_visible_to_customers'] = $request->boolean('is_visible_to_customers');

        $product->update($data);

        return redirect()->route('products.edit');
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
            'sku' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_visible_to_customers' => ['required', 'boolean'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
        return $data;
    }
}
