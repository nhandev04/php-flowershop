<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        // Get cart items from session
        $cartItems = $this->getCartItems();

        // Calculate cart totals
        $subtotal = 0;
        $discount = 0;
        $taxRate = 0.10; // 10% tax
        $shipping = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        // Apply coupon discount if exists
        if (Session::has('coupon_discount')) {
            $discount = Session::get('coupon_discount');
        }

        // Calculate tax
        $tax = ($subtotal - $discount) * $taxRate;

        // Free shipping for orders above $100
        $shipping = ($subtotal - $discount < 100 && $subtotal > 0) ? 10 : 0;

        // Calculate total
        $total = $subtotal - $discount + $tax + $shipping;

        return view('client.cart.index', compact('cartItems', 'subtotal', 'discount', 'tax', 'taxRate', 'shipping', 'total'));
    }

    /**
     * Add a product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        // Check if product is in stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'This product is out of stock.');
        }

        $cart = Session::get('cart', []);
        $cartId = $request->input('product_id');

        // If item already in cart, update quantity
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->input('quantity');
        } else {
            // Add new item to cart
            $cart[$cartId] = [
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] = $request->input('quantity');
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Cart item not found!');
    }

    /**
     * Remove item from cart
     */
    public function remove($cartItemId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
        }

        return redirect()->route('cart.index')->with('error', 'Cart item not found!');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|string|max:50',
        ]);

        $couponCode = strtoupper($request->input('coupon'));

        // Simple coupon codes for demonstration
        $validCoupons = [
            'WELCOME10' => 10, // $10 off
            'SAVE20' => 20,    // $20 off
            'FLOWER15' => 15,  // $15 off
        ];

        if (array_key_exists($couponCode, $validCoupons)) {
            Session::put('coupon_code', $couponCode);
            Session::put('coupon_discount', $validCoupons[$couponCode]);
            return redirect()->route('cart.index')->with([
                'coupon_success' => true,
                'coupon_message' => "Coupon '{$couponCode}' applied successfully! You saved \${$validCoupons[$couponCode]}."
            ]);
        }

        return redirect()->route('cart.index')->with([
            'coupon_success' => false,
            'coupon_message' => "Invalid coupon code. Please try again."
        ]);
    }

    /**
     * Get cart items from session with products
     */
    private function getCartItems()
    {
        $cart = Session::get('cart', []);
        $cartItems = collect();

        foreach ($cart as $id => $item) {
            $product = Product::find($item['product_id']);

            if ($product) {
                // Convert to object for consistency with models
                $cartItem = (object) [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];

                $cartItems->push($cartItem);
            }
        }

        return $cartItems;
    }
}
