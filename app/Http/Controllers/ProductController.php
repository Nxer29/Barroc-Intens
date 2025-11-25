<?php

namespace App\Http\Controllers;

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

    public function show($id)
    {
        $product = $this->demoProducts()->firstWhere('id', (int)$id);
        abort_unless($product, 404);
        return view('products.show', compact('product'));
    }
}
