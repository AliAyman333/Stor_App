<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user:id,name,email')->get();

        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employee::with('user:id,name,email')->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $employee = $user->employee()->with('user:id,name,email')->first();

        if (!$employee) {
            return response()->json(['message' => 'You are not an employee'], 403);
        }

        return response()->json($employee);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:employees,user_id',
            'department' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric',
        ]);

        $employee = Employee::create([
            'user_id' => $request->user_id,
            'department' => $request->department,
            'salary' => $request->salary,
        ]);

        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee->load('user:id,name,email'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id|unique:employees,user_id,' . $employee->id,
            'department' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric',
        ]);

        $employee->update($request->only(['user_id', 'department', 'salary']));

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee->fresh()->load('user:id,name,email'),
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully',
        ]);
    }
}
