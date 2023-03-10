<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $signUp = new Signup();
        $signUp->email = $request->email;
        $signUp->name = $request->name;
        $signUp->password = Hash::make($request->pasword);
        $signUp->save();
        return $signUp;
      }
}
