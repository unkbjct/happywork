<?php

namespace App\Http\Controllers\User\Get;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup()
    {
        return view('user.signup');
    }

    public function login()
    {
        return view('user.login');
    }

    public function profile()
    {
        return view('user.profile', [
            'sectionName' => 'Мой кабинет'
        ]);
    }

    public function favorite()
    {
        return view('user.favorite', [
            'sectionName' => 'Избранные товары'
        ]);
    }

    public function history()
    {
        return view('user.history', [
            'sectionName' => 'Мои заказы'
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
