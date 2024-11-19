<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validasi = Validator::make($request->all(), [
            'type' => 'required|in:pemilik,penyewa',
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:pemilik|unique:penyewa',
            'password' => 'required|min:8',
            'no_telp' => 'nullable|required'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'message' => $validasi->errors()
            ], 400);
        }

        $model = $request->type === 'pemilik' ? \App\Models\Pemilik::class : \App\Models\Penyewa::class;

        $user = $model::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  password_hash($request->password, PASSWORD_BCRYPT),
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
            'status' => true,
            'message' => "Registrasi {$request->type} berhasil",
            'data' => $user
        ], 200);
    }
}
