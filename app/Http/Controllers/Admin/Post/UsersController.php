<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function edit(Request $request)
    {
        $user = User::find($request->user);
        $user->status = $request->status;
        $user->save();
        $statusText = ($request->status == "ADMIN") ? "Администратор" : "Пользователь";
        return response([
            'ok' => true,
            'message' => "Пользователю № {$user->id} присвоин статус \"{$statusText}\"",
            'data' => [],
        ], 200);
    }
}
