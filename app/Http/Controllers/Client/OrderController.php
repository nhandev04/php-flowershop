<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the order confirmation page.
     */
    public function confirmation(Order $order)
    {
        // Check if the order belongs to the current user
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        return view('client.orders.confirmation', compact('order'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if the order belongs to the current user
        if ($order->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $order->load('items.product');

        return view('client.orders.show', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Request $request, Order $order)
    {
        // Check if the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancelling orders that are in pending or processing status
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->status = 'cancelled';
        $order->cancelled_at = now();
        $order->save();

        // Restore product stock
        foreach ($order->items as $item) {
            if ($item->product && $item->product->manage_stock) {
                $item->product->stock_quantity += $item->quantity;

                if ($item->product->stock_status === 'out_of_stock' && $item->product->stock_quantity > 0) {
                    $item->product->stock_status = 'in_stock';
                }

                $item->product->save();
            }
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order has been cancelled.');
    }
}
