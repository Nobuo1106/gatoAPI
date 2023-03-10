<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Signup;

class SignInController extends Controller
{
    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = Signup::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $user->createToken();

        return response()->json(['token' => $token]);
    }
}
