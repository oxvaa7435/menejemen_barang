<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        // Check stock for each item
        foreach ($order->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok material {$item->product->name} tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                // Deduct stock
                $item->product->decrement('stock', $item->quantity);

                // Record transaction
                StockTransaction::create([
                    'product_id' => $item->product_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'description' => "Order #{$order->id} Approved",
                ]);
            }

            $order->update(['status' => 'approved']);
        });

        return back()->with('success', 'Pesanan disetujui dan stok telah diperbarui.');
    }

    public function reject(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Pesanan ditolak.');
    }
}
