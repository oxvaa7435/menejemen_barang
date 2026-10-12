<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stok Barang Terbaru (Latest Stock)
        $latestStock = Product::latest()->take(5)->get(); // Modified based on instruction

        // 2. Produk Terlaris (Best Selling) - Based on confirmed orders
        $bestSelling = OrderItem::select('products.name', 'product_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('product_id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // 3. Pesanan Masuk/Keluar (Monthly stats)
        $ordersCount = Order::select(DB::raw('status'), DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact('latestStock', 'bestSelling', 'ordersCount'));
    }

    public function userIndex()
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $approvedMaterials = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', auth()->id())
            ->where('orders.status', 'approved')
            ->select('products.name', 'products.code', 'products.unit', DB::raw('SUM(order_items.quantity) as total_received'))
            ->groupBy('products.id', 'products.name', 'products.code', 'products.unit')
            ->get();

        return view('dashboard', compact('approvedMaterials'));
    }
}
