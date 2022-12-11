<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public  function  __construct()
    {
    }
    public  function  login()
    {
        return view('login');
    }
    public  function  authenticate(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        Auth::attempt($data);
        return redirect()->route('event.page');
    }
}
