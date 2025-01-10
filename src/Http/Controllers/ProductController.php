<?php

namespace Dev3bdulrahman\LicenseManager\Http\Controllers;

use Dev3bdulrahman\LicenseManager\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('licenses')->get();

        return view('license-manager::products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'status' => 'required|string',
        ]);
        Product::create($validated);

        return redirect()->route('license-manager.products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        return view('license-manager::products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $product->update($validated);

        return redirect()->route('license-manager.products.index')
            ->with('success', 'Product updated successfully');
    }
}
