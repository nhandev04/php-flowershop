<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get the cart items for the current user
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add some products before checking out.');
        }

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Apply tax, shipping, and discounts
        $taxRate = 0.10; // 10% tax
        $tax = $subtotal * $taxRate;

        // Shipping is free for orders over $100
        $shipping = ($subtotal > 100) ? 0 : 10;

        // Get discount from session
        $discount = session('discount', 0);

        // Calculate total
        $total = $subtotal - $discount + $tax + $shipping;

        return view('client.checkout.index', compact('cartItems', 'subtotal', 'tax', 'taxRate', 'shipping', 'discount', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,credit_card',
            'terms_accepted' => 'required|accepted',
        ]);

        // Get cart items
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $taxRate = 0.10; // 10% tax
        $tax = $subtotal * $taxRate;

        // Shipping is free for orders over $100
        $shipping = ($subtotal > 100) ? 0 : 10;

        // Get discount from session
        $discount = session('discount', 0);

        // Calculate total
        $total = $subtotal - $discount + $tax + $shipping;

        try {
            // Create the order
            $order = new Order();
            $order->user_id = auth()->id();
            $order->order_number = 'ORD-' . strtoupper(substr(uniqid(mt_rand(), true), 0, 8));
            $order->status = 'pending';
            $order->payment_status = $request->payment_method === 'cod' ? 'pending' : 'pending';
            $order->payment_method = $request->payment_method;

            // Set billing details
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip_code = $request->zip_code;

            // Set shipping details if different
            if ($request->different_shipping) {
                $request->validate([
                    'shipping_first_name' => 'required|string|max:255',
                    'shipping_last_name' => 'required|string|max:255',
                    'shipping_address' => 'required|string|max:255',
                    'shipping_city' => 'required|string|max:100',
                    'shipping_state' => 'required|string|max:100',
                    'shipping_zip_code' => 'required|string|max:20',
                    'shipping_phone' => 'required|string|max:20',
                ]);

                $order->different_shipping = true;
                $order->shipping_first_name = $request->shipping_first_name;
                $order->shipping_last_name = $request->shipping_last_name;
                $order->shipping_address = $request->shipping_address;
                $order->shipping_city = $request->shipping_city;
                $order->shipping_state = $request->shipping_state;
                $order->shipping_zip_code = $request->shipping_zip_code;
                $order->shipping_phone = $request->shipping_phone;
            } else {
                $order->different_shipping = false;
            }

            // Set order notes if provided
            $order->notes = $request->notes;

            // Set order totals
            $order->subtotal = $subtotal;
            $order->tax = $tax;
            $order->shipping = $shipping;
            $order->discount = $discount;
            $order->total = $total;

            $order->save();

            // Create order items
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->product_name = $cartItem->product->name;
                $orderItem->price = $cartItem->product->price;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->save();

                // Update product stock
                $product = $cartItem->product;
                if ($product->manage_stock) {
                    $product->stock_quantity = max(0, $product->stock_quantity - $cartItem->quantity);

                    if ($product->stock_quantity === 0) {
                        $product->stock_status = 'out_of_stock';
                    }

                    $product->save();
                }
            }

            // Clear the cart
            Cart::where('user_id', auth()->id())->delete();

            // Clear discount session
            session()->forget(['discount', 'coupon_code', 'coupon_message', 'coupon_success']);

            // Redirect to order confirmation
            return redirect()->route('orders.confirmation', $order);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }
}
