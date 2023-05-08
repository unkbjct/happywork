<?php

namespace App\Http\Controllers\Single\Post;

use App\Http\Controllers\Controller;
use App\Models\Repair_applicant;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function repair(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|max:222',
            'phone' => 'required|max:222',
            'mobile' => 'max:222',
            'description' => 'max:5000'
        ], [], [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'mobile' => 'Модель телефона',
            'description' => 'Описание проблемы',
        ]);

        // return;

        $applicant = new Repair_applicant();
        $applicant->name = $request->name;
        $applicant->phone = $request->phone;
        $applicant->mobile = $request->mobile;
        $applicant->description = $request->description;
        $applicant->save();
        
        return response([
            'ok' => true,
            'message' => 'Заявка успешно отправлена, ожидайте звонка',
            'data' => [],
        ], 200);
    }
}
