<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user:id,name,email', 'product:id,name,price'])->latest()->get();

        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::with(['user:id,name,email', 'product:id,name,price'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'nullable|string|max:50',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $totalPrice = $product->price * $quantity;

        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order->load(['user:id,name,email', 'product:id,name,price']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'status' => 'nullable|string|max:50',
        ]);

        if ($request->has('product_id') || $request->has('quantity')) {
            $productId = $request->get('product_id', $order->product_id);
            $product = Product::findOrFail($productId);
            $quantity = (int) $request->get('quantity', $order->quantity);
            $order->total_price = $product->price * $quantity;
        }

        $order->fill($request->only(['user_id', 'product_id', 'quantity', 'status']));
        $order->save();

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order->fresh()->load(['user:id,name,email', 'product:id,name,price']),
        ]);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
    }
}
