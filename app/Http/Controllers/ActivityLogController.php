<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user:id,name,email')->latest()->get();

        return response()->json($logs);
    }

    public function show($id)
    {
        $log = ActivityLog::with('user:id,name,email')->find($id);

        if (!$log) {
            return response()->json(['message' => 'Activity log not found'], 404);
        }

        return response()->json($log);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string|max:45',
        ]);

        $log = ActivityLog::create([
            'user_id' => $request->user_id,
            'action' => $request->action,
            'description' => $request->description,
            'ip_address' => $request->ip_address ?? $request->ip(),
        ]);

        return response()->json([
            'message' => 'Activity log created successfully',
            'activity_log' => $log->load('user:id,name,email'),
        ], 201);
    }

    public function destroy($id)
    {
        $log = ActivityLog::find($id);

        if (!$log) {
            return response()->json(['message' => 'Activity log not found'], 404);
        }

        $log->delete();

        return response()->json([
            'message' => 'Activity log deleted successfully',
        ]);
    }
}
