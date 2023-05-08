<?php

namespace App\Http\Controllers\Admin\Get;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function list(Request $request)
    {
        $request->flash();

        $users = User::orderByDesc("id");

        if ($request->has('id') && $request->id) $users->where("id", "=", "$request->id");
        if ($request->has('phone') && $request->phone) $users->where("phone", "LIKE", "%{$request->phone}%");
        if ($request->has('email') && $request->email) $users->where("email", "LIKE", "%{$request->email}%");
        if ($request->has('status') && $request->status) $users->where("status", "=", "$request->status");

        $users = $users->get();

        return view('admin.users.list', [
            'users' => $users,
        ]);
    }
}
