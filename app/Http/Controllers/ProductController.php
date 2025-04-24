<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'brand' => 'nullable',
            'category' => 'nullable',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'expiration_date' => 'nullable|date',
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required',
            'brand' => 'nullable',
            'category' => 'nullable',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'expiration_date' => 'nullable|date',
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
