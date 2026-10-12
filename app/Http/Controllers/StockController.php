<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with('product')->orderBy('created_at', 'desc')->get();
        $products = Product::all();
        return view('admin.stock.index', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // Create Transaction
            StockTransaction::create([
                'product_id' => $request->product_id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'description' => $request->description ?? 'Barang Masuk'
            ]);

            // Update Product Stock
            $product = Product::find($request->product_id);
            $product->increment('stock', $request->quantity);
        });

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan!');
    }
}
