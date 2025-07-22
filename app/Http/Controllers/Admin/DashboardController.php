<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();

        // Get order statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Get total sales
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        // Get recent orders and products
        $latestOrders = Order::with(['customer'])->latest()->take(5)->get();
        $latestProducts = Product::latest()->take(5)->get();

        // Get top selling products
        $topSellingProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();

        // Get low stock products
        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('is_active', true)
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'cancelledOrders',
            'totalSales',
            'latestOrders',
            'latestProducts',
            'topSellingProducts',
            'lowStockProducts'
        ));
    }
}
