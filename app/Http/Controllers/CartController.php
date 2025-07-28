<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all()->groupBy('cart_barcode');
        return view('cart.index', compact('carts'));
    }

   public function create()
{
    return view('cart._scan_modal');
}

    
       
public function store(Request $request)
{
    $count = count($request->input('production_barcode'));

    for ($i = 0; $i < $count; $i++) {
        \App\Models\Cart::create([
            'cart_barcode' => $request->input('cart_barcode'),
            'production_barcode' => $request->input('production_barcode')[$i] ?? null,
            'description' => $request->input('description')[$i] ?? null,
            'width' => $request->input('width')[$i] ?? null,
            'height' => $request->input('height')[$i] ?? null,
            'order_number' => $request->input('order_number')[$i] ?? null,
            'comment' => $request->input('comment')[$i] ?? null,
            'customer_number' => $request->input('customer_number')[$i] ?? null,
            'customer_short_name' => $request->input('customer_short_name')[$i] ?? null,
        ]);

        $orderNumber = $request->input('order_number')[$i] ?? null;
        if ($orderNumber) {
            $this->updateDeliveryCartsField($orderNumber);
        }
    }

    return redirect()->route('cart.index')->with('success', 'Cart items saved successfully.');
}


public function update(Request $request, $cart_barcode)
{
    $cartItems = Cart::where('cart_barcode', $cart_barcode)->get();
    foreach ($cartItems as $index => $cart) {
        $cart->update([
            'production_barcode' => $request->production_barcode[$index] ?? $cart->production_barcode,
            'description' => $request->description[$index] ?? $cart->description,
            'width' => $request->width[$index] ?? $cart->width,
            'height' => $request->height[$index] ?? $cart->height,
            'order_number' => $request->order_number[$index] ?? $cart->order_number,
            'comment' => $request->comment[$index] ?? $cart->comment,
            'customer_number' => $request->customer_number[$index] ?? $cart->customer_number,
            'customer_short_name' => $request->customer_short_name[$index] ?? $cart->customer_short_name,
        ]);
    }

    $orderNumber = $request->order_number[0] ?? null;
    if ($orderNumber) {
        $this->updateDeliveryCartsField($orderNumber);
    }

    return redirect()->route('cart.index')->with('success', 'Cart items updated successfully.');
}


private function updateDeliveryCartsField($orderNumber)
{
    $cartBarcodes = \App\Models\Cart::where('order_number', $orderNumber)
        ->pluck('cart_barcode')
        ->unique()
        ->toArray();

    $cartList = implode('; ', $cartBarcodes);

    \App\Models\Delivery::where('order_number', $orderNumber)->update([
        'carts' => $cartList,
    ]);
}


}
