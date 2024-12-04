<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Pemilik;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Admin::where('email', $request->email)->first()
            ?? Pemilik::where('email', $request->email)->first()
            ?? Penyewa::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan!'
            ], 404);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        Mail::send('emails.reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
        });

        return response()->json([
            'success' => true,
            'message' => 'Password Reset link sent!'
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where([
            ['email', '=', $request->email],
            ['created_at', '>', now()->subMinutes(60)]
        ])->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token!'
            ], 400);
        }

        $user = Admin::where('email', $request->email)->first()
            ?? Pemilik::where('email', $request->email)->first()
            ?? Penyewa::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password reset succesfully!'
        ], 200);
    }

    public function showResetPassword(Request $request) {
        $token = $request->query('token');

        if (!$token) {
            return response()->json([
                'message' => 'Token is required'
            ], 400);
        }

        // return view('emails.reset_password', ['token' => $token]);
        return response()->json([
            'success' =>true,
            'message' => 'Reset Password from can be rendered here.',
            'token' => $token
        ]);
    }
}
