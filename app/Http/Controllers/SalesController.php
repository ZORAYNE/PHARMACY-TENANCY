<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('sales.index', compact('products'));
    }

    public function store(Request $request)
    {
        $productIds = $request->products;

        $sale = Sale::create([
            'total' => Product::whereIn('id', $productIds)->sum('price'),
        ]);

        foreach ($productIds as $id) {
            $product = Product::find($id);
            $sale->products()->attach($product);

            // reduce stock
            $product->stock -= 1;
            $product->save();
        }

        return redirect()->route('sales.index')->with('success', 'Transaction completed successfully.');
    }
}
