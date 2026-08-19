<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

//تغيير
class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,employee,customer',
        ]);

        // محاولة تسجيل الدخول بالبيانات المرسلة
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        // جلب بيانات المستخدم بعد نجاح التحقق
        $user = Auth::user();

        $roleRelations = [
            'admin' => 'admin',
            'employee' => 'employee',
            'customer' => 'customer',
        ];
        $role = $request->string('role')->toString();

        if (!$user->{$roleRelations[$role]}()->exists()) {
            Auth::logout();

            return response()->json([
                'message' => 'The selected role is not assigned to this user',
            ], 403);
        }

        // تأكد من أن النموذج يدعم إنشاء التوكنات قبل استدعاء createToken
        $token = null;
        if (method_exists($user, 'createToken')) {
            $token = $user->createToken('auth_token')->plainTextToken;
        }

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        // حذف التوكن الحالي المستخدم في الجلسة
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }
    
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function user_show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }
    public function user_delete($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
