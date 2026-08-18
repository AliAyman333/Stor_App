<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user:id,name,email')->get();

        return response()->json($admins);
    }

    public function show($id)
    {
        $admin = Admin::with('user:id,name,email')->find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json($admin);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $admin = $user->admin()->with('user:id,name,email')->first();

        if (!$admin) {
            return response()->json(['message' => 'You are not an admin'], 403);
        }

        return response()->json($admin);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:admins,user_id',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);

        $admin = Admin::create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'position' => $request->position,
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin' => $admin->load('user:id,name,email'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id|unique:admins,user_id,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
        ]);

        $admin->update($request->only(['user_id', 'phone', 'position']));

        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin->fresh()->load('user:id,name,email'),
        ]);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();

        return response()->json([
            'message' => 'Admin deleted successfully',
        ]);
    }
}
