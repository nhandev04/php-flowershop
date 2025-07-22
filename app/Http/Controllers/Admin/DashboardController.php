<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $latestProducts = Product::latest()->take(5)->get();
        $latestOrders = Order::with('customer')->latest()->take(5)->get();
        $totalCustomers = Customer::count();
        $totalCategories = Category::count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'latestProducts',
            'latestOrders',
            'totalCustomers',
            'totalCategories'
        ));
    }
}
