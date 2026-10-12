<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Product::latest()->get();
        $transactions = \App\Models\StockTransaction::with('product')->latest()->take(10)->get();
        return view('admin.materials.index', compact('materials', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required',
            'unit' => 'required|in:lembar,ROL,KG',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return back()->with('success', 'Material berhasil ditambahkan!');
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        \Illuminate\Support\Facades\DB::transaction(function () use ($product, $request) {
            $product->increment('stock', $request->quantity);

            \App\Models\StockTransaction::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'description' => $request->description ?? 'Barang Masuk (Manual)',
            ]);
        });

        return back()->with('success', 'Stok material berhasil ditambah.');
    }

    public function update(Request $request, Product $material)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $material->id,
            'name' => 'required',
            'unit' => 'required|in:lembar,ROL,KG',
            'stock' => 'required|integer|min:0',
        ]);

        $material->update($request->all());

        return back()->with('success', 'Material berhasil diperbarui!');
    }

    public function destroy(Product $material)
    {
        $material->delete();
        return back()->with('success', 'Material berhasil dihapus!');
    }
}
