<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems'])->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('admin.orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Calculate total amount
        $total_amount = 0;
        $orderItems = [];

        foreach ($validated['products'] as $item) {
            $product = Product::findOrFail($item['id']);
            $price = $product->price;
            $quantity = $item['quantity'];

            // Check stock availability
            if ($product->stock < $quantity) {
                return redirect()->back()->withErrors([
                    'products' => "Insufficient stock for {$product->name}. Available: {$product->stock}"
                ])->withInput();
            }

            $total_amount += $price * $quantity;

            $orderItems[] = [
                'product_id' => $item['id'],
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Create order
        $order = Order::create([
            'customer_id' => $validated['customer_id'],
            'total_amount' => $total_amount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $order->orderItems()->create($item);

            // Update product stock
            $product = Product::findOrFail($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        $customers = Customer::all();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Update order status
        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        $order->update([
            'status' => $newStatus,
            'notes' => $validated['notes'],
        ]);

        // If cancelled, restore product stock
        if ($oldStatus != 'cancelled' && $newStatus == 'cancelled') {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // If not cancelled, restore product stock
        if ($order->status != 'cancelled') {
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
        }

        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
