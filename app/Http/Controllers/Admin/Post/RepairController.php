<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Repair_applicant;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function remove(Request $request)
    {
        Repair_applicant::find($request->repair)->delete();
        return response([
            'ok' => true,
            'message' => 'Заявка удалена успешно',
            'data' => [],
        ], 200);
    }
}
