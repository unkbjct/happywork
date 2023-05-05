<?php

namespace App\Http\Controllers\User\Post;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users',
            'phone' => 'required|unique:users',
            'passwd' => 'min:6',
        ], [], [
            'name' => 'Имя',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'passwd' => 'Пароль',
        ]);



        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->passwd;
        $user->passwd = $request->passwd;
        $user->api_token = Str::random(60);
        $user->address_index = null;
        $user->save();

        if (Auth::attempt(['password' => $request->passwd, 'email' => $request->email], true)) {
            return response([
                'ok' => true,
                'data' => [
                    'url' => route('user.profile'),
                    'user' => $user,
                ]
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'passwd' => 'required',
        ], [], [
            'email' => 'Почта',
            'passwd' => 'Пароль',
        ]);

        if (Auth::attempt(['password' => $request->passwd, 'email' => $request->email], true)) {

            return response([
                'ok' => true,
                'data' => [
                    'url' => route('user.profile'),
                    'user' => Auth::user(),
                ]
            ], 200);
        } else {

            return response([
                'ok' => false,
                'data' => [
                    'errors' => [
                        'email' => '',
                        'passwd' => 'Пользователь не найден!',
                    ]
                ]
            ], 422);
        }
    }

    public function editPersonal(Request $request)
    {

        $user = User::where("api_token", $request->api_token)->first();
        if (!$user) return response('', 403);

        $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'passwd' => 'required',
        ], [], [
            'name' => 'Имя',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'passwd' => 'Пароль',
        ]);


        $errs = [];
        if ($user->email != $request->input('email') && User::where('email', $request->input('email'))->first()) $errs['email'] = 'Почта уже кем-то используется!';
        if ($user->phone != $request->input('phone') && User::where('phone', $request->input('phone'))->first()) $errs['phone'] = 'Телефон уже кем-то используется!';

        if ($errs) {
            return response([
                'ok' => false,
                'data' => [
                    'errors' => $errs
                ]
            ], 422);
        };

        if ($user->name != $request->name) $user->name = $request->name;
        if ($user->email != $request->email) $user->email = $request->email;
        if ($user->phone != $request->phone) $user->phone = $request->phone;
        if ($user->passwd != $request->passwd) {
            $user->password = $request->passwd;
            $user->passwd = $request->passwd;
        }
        $user->save();

        return response([
            'ok' => true,
            'message' => 'Персональные данные сохранены успешно',
            'data' => [
                'user' => $user,
            ]
        ], 200);
    }

    public function editAddress(Request $request)
    {

        $user = User::where("api_token", $request->api_token)->first();
        if (!$user) return response('', 403);

        $request->validate([
            'address_index' => 'nullable|numeric',
        ], [], [
            'address_index' => 'Индекс',
        ]);

        if ($user->area != $request->area) $user->area = $request->area;
        if ($user->city != $request->city) $user->city = $request->city;
        if ($user->address_index != $request->address_index) $user->address_index = $request->address_index;
        if ($user->address != $request->address) $user->address = $request->address;
        $user->save();

        return response([
            'ok' => true,
            'message' => 'Адрес доставки успешно сохранен',
            'data' => [
                'user' => $user,
            ]
        ], 200);
    }
}
