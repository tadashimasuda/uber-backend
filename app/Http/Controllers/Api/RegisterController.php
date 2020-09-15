<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Hash, DB};

class RegisterController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>['required'],
            'email'=>['required','email','unique:users'],
            'password' => ['required','min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return 'ok';
    }
}