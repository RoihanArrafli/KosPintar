<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Str;
use App\Models\Pemilik;
use App\Models\Penyewa;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $input = Validator::make($request->all(), [
            'role' => 'required|in:pemilik,penyewa',
            'name' => 'required|string|max:255',
            'no_telp' => 'required|max:15',
            'email' => 'required|email|unique:pemilik|unique:penyewa',
            'password' => 'required|string|min:8'
        ]);
        

        if ($input->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalan ' . $input->errors()
            ], 200);
        }

        $data = $request->only('name', 'no_telp', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
        $user = NULL;

        if ($request->role === 'pemilik') {
            $user = Pemilik::create($data);
        } elseif ($request->role === 'penyewa') {
            $user = Penyewa::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'User berhasil registrasi!',
            'data' => $user,
            'role' => $request->role
        ], 200);
    }

    public function login(Request $request) {
        $input = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($input->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan ' . $input->errors()
            ], 200);
        }

        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login sukses!',
                'data' => $admin,
                'role' => 'admin'
            ]);
        }

        $pemilik = Pemilik::where('email', $request->email)->first();
        if ($pemilik && Hash::check($request->password, $pemilik->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login sukses!',
                'data' => $pemilik,
                'role' => 'pemilik'
            ]);
        }

        $penyewa = Penyewa::where('email', $request->email)->first();
        if ($penyewa && Hash::check($request->password, $penyewa->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login sukses!',
                'data' => $penyewa,
                'role' => 'penyewa'
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 400);
    }
}
