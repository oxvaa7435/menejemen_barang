<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('user.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi untuk pesanan ini.');
        }

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        });

        return redirect()->route('user.orders.index')->with('success', 'Pesanan berhasil dibuat! Menunggu persetujuan admin.');
    }
}
