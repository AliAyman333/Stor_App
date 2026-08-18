<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user:id,name,email')->get();

        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::with('user:id,name,email')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $customer = $user->customer()->with('user:id,name,email')->first();

        if (!$customer) {
            return response()->json(['message' => 'You are not a customer'], 403);
        }

        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:customers,user_id',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer = Customer::create([
            'user_id' => $request->user_id,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer->load('user:id,name,email'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id|unique:customers,user_id,' . $customer->id,
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($request->only(['user_id', 'address', 'phone']));

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer->fresh()->load('user:id,name,email'),
        ]);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully',
        ]);
    }
}
