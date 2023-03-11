<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $signUp = new Signup();
        $signUp->name = $request->name;
        $signUp->email = $request->email;
        $signUp->phone = $request->phone;
        $signUp->password = Hash::make($request->pasword);
        $signUp->save();
        return $signUp;
      }
}
